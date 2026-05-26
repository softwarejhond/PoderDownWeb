-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 26-05-2026 a las 01:46:27
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `activo`, `created_at`) VALUES
(1, 'Electrónica', 'Dispositivos y gadgets tecnológicos', 1, '2026-05-06 20:36:30'),
(2, 'Ropa', 'Moda y accesorios de vestir', 1, '2026-05-06 20:36:30'),
(3, 'Hogar', 'Artículos para el hogar y decoración', 1, '2026-05-06 20:36:30'),
(4, 'Deportes', 'Equipos y ropa deportiva', 1, '2026-05-06 20:36:30'),
(5, 'Libros', 'Literatura, ciencia y entretenimiento', 1, '2026-05-06 20:36:30'),
(6, 'Electrónica', 'Dispositivos y gadgets tecnológicos', 1, '2026-05-06 20:36:40'),
(7, 'Ropa', 'Moda y accesorios de vestir', 1, '2026-05-06 20:36:40'),
(8, 'Hogar', 'Artículos para el hogar y decoración', 1, '2026-05-06 20:36:40'),
(9, 'Deportes', 'Equipos y ropa deportiva', 1, '2026-05-06 20:36:40'),
(10, 'Libros', 'Literatura, ciencia y entretenimiento', 1, '2026-05-06 20:36:40'),
(11, 'Electrónica', 'Dispositivos y gadgets tecnológicos', 1, '2026-05-06 21:28:35'),
(12, 'Ropa', 'Moda y accesorios de vestir', 1, '2026-05-06 21:28:35'),
(13, 'Hogar', 'Artículos para el hogar y decoración', 1, '2026-05-06 21:28:35'),
(14, 'Deportes', 'Equipos y ropa deportiva', 1, '2026-05-06 21:28:35'),
(15, 'Libros', 'Literatura, ciencia y entretenimiento', 1, '2026-05-06 21:28:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `notas` text,
  `estado` enum('pendiente','confirmado','preparando','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id` int UNSIGNED NOT NULL,
  `pedido_id` int UNSIGNED NOT NULL,
  `producto_id` int UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int UNSIGNED NOT NULL,
  `categoria_id` int UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `imagen` varchar(255) DEFAULT 'default.jpg',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `activo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smartphone Pro X', 'Pantalla AMOLED 6.7\", 256GB, cámara 108MP', 899.99, 45, 'smartphone.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(2, 1, 'Laptop UltraSlim 14', 'Intel Core i7, 16GB RAM, SSD 512GB', 1299.99, 20, 'laptop.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(3, 1, 'Auriculares Noise Pro', 'Cancelación activa de ruido, 30h batería', 199.99, 80, 'auriculares.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(4, 2, 'Camiseta Deportiva Dry', 'Tela transpirable, disponible en 4 tallas', 29.99, 200, 'camiseta.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(5, 2, 'Chaqueta Urban Style', 'Impermeable, ligera, colores variados', 89.99, 60, 'chaqueta.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(6, 3, 'Lámpara LED Minimalista', 'Luz regulable, brazo articulado, USB-C', 49.99, 110, 'lampara.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(7, 3, 'Silla Ergonómica Pro', 'Soporte lumbar, altura ajustable, ruedas', 349.99, 25, 'silla.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(8, 4, 'Bicicleta MTB Xcross', 'Aluminio 29\", 21 velocidades, frenos disco', 599.99, 15, 'bicicleta.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(9, 4, 'Mancuernas Ajustables', 'Par 5-25kg, agarre antideslizante', 129.99, 40, 'mancuernas.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(10, 5, 'Clean Code - R.Martin', 'Edición en español, tapa blanda', 34.99, 500, 'libro1.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(11, 5, 'Diseño UX/UI Moderno', 'Guía práctica con ejemplos reales', 27.99, 300, 'libro2.jpg', 1, '2026-05-06 20:36:30', '2026-05-06 20:36:30'),
(17, 2, 'Chaqueta Urban Style', 'Impermeable, ligera, colores variados', 89.99, 60, 'chaqueta.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(18, 3, 'Lámpara LED Minimalista', 'Luz regulable, brazo articulado, USB-C', 49.99, 110, 'lampara.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(19, 3, 'Silla Ergonómica Pro', 'Soporte lumbar, altura ajustable, ruedas', 349.99, 25, 'silla.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(20, 4, 'Bicicleta MTB Xcross', 'Aluminio 29\", 21 velocidades, frenos disco', 599.99, 15, 'bicicleta.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(21, 4, 'Mancuernas Ajustables', 'Par 5-25kg, agarre antideslizante', 129.99, 40, 'mancuernas.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(22, 5, 'Clean Code - R.Martin', 'Edición en español, tapa blanda', 34.99, 500, 'libro1.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(23, 5, 'Diseño UX/UI Moderno', 'Guía práctica con ejemplos reales', 27.99, 300, 'libro2.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(24, 1, 'Tablet DrawPad 12', 'Pantalla 12\", lápiz óptico incluido, WiFi', 449.99, 30, 'tablet.jpg', 1, '2026-05-06 20:36:40', '2026-05-06 20:36:40'),
(25, 1, 'Smartphone Pro X', 'Pantalla AMOLED 6.7\", 256GB, cámara 108MP', 899.99, 45, 'smartphone.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(26, 1, 'Laptop UltraSlim 14', 'Intel Core i7, 16GB RAM, SSD 512GB', 1299.99, 20, 'laptop.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(27, 1, 'Auriculares Noise Pro', 'Cancelación activa de ruido, 30h batería', 199.99, 80, 'auriculares.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(28, 2, 'Camiseta Deportiva Dry', 'Tela transpirable, disponible en 4 tallas', 29.99, 200, 'camiseta.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(29, 2, 'Chaqueta Urban Style', 'Impermeable, ligera, colores variados', 89.99, 60, 'chaqueta.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(30, 3, 'Lámpara LED Minimalista', 'Luz regulable, brazo articulado, USB-C', 49.99, 110, 'lampara.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(31, 3, 'Silla Ergonómica Pro', 'Soporte lumbar, altura ajustable, ruedas', 349.99, 25, 'silla.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(32, 4, 'Bicicleta MTB Xcross', 'Aluminio 29\", 21 velocidades, frenos disco', 599.99, 15, 'bicicleta.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(33, 4, 'Mancuernas Ajustables', 'Par 5-25kg, agarre antideslizante', 129.99, 40, 'mancuernas.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(34, 5, 'Clean Code - R.Martin', 'Edición en español, tapa blanda', 34.99, 500, 'libro1.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35'),
(35, 5, 'Diseño UX/UI Moderno', 'Guía práctica con ejemplos reales', 27.99, 300, 'libro2.jpg', 1, '2026-05-06 21:28:35', '2026-05-06 21:28:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `pedido_items_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_items_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
