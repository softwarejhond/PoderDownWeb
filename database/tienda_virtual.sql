-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db:3306
-- Tiempo de generaciÃ³n: 16-06-2026 a las 23:10:00
-- VersiÃ³n del servidor: 10.6.27-MariaDB-ubu2204
-- VersiÃ³n de PHP: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_virtual`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'ID del admin (tabla users)',
  `action` varchar(100) NOT NULL COMMENT 'Ej: product_created, order_updated',
  `entity_type` varchar(50) DEFAULT NULL COMMENT 'Ej: product, order, customer',
  `entity_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `old_values` text DEFAULT NULL COMMENT 'Valores anteriores (JSON)',
  `new_values` text DEFAULT NULL COMMENT 'Valores nuevos (JSON)',
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `link_url` varchar(500) DEFAULT NULL,
  `link_target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `position` enum('home_slider','home_banner','category_banner','popup') NOT NULL DEFAULT 'home_slider',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL COMMENT 'NULL para carritos de invitados',
  `session_id` varchar(255) DEFAULT NULL COMMENT 'Para invitados no logueados',
  `coupon_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL COMMENT 'Precio al momento de agregar',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'NULL = categor??a ra??z',
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `image`, `icon`, `sort_order`, `is_active`, `is_featured`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Arte', 'arte', 'Productos como cuadros, etc', NULL, 'bi bi-brush', 0, 1, 1, NULL, NULL, '2026-06-04 22:53:47', '2026-06-05 00:49:20'),
(2, NULL, 'Ropa', 'ropa', 'Camisetas, hoodies y mÃ¡s con diseÃ±os exclusivos de Poder Down', NULL, 'bi bi-handbag', 0, 1, 1, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(3, NULL, 'Accesorios', 'accesorios', 'Gorras, bolsos, joyerÃ­a artesanal', NULL, 'bi bi-gem', 0, 1, 1, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(4, NULL, 'PapelerÃ­a', 'papeleria', 'Libretas, stickers, postales con arte original', NULL, 'bi bi-journal', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(5, NULL, 'Hogar', 'hogar', 'Tazas, cojines, decoraciÃ³n para tu espacio', NULL, 'bi bi-house-heart', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(6, NULL, 'Lienzos y Cuadros', 'lienzos-cuadros', 'Impresiones de alta calidad de las obras de Cami', NULL, 'bi bi-image', 0, 1, 1, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:11:47'),
(7, 1, 'Pinturas Originales', 'pinturas-originales', 'Obras Ãºnicas originales de MarÃ­a Camila GonzÃ¡lez Torres', NULL, 'bi bi-palette', 0, 1, 1, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(8, NULL, 'Eventos', 'eventos', 'Aprende y comparte en talleres dirigidos por Cami', NULL, 'bi bi-calendar-event', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:11:47'),
(9, 2, 'Mochilas', 'mochilas', 'Mochilas con diseÃ±os inspirados en Poder Down', NULL, 'bi bi-bag', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(10, NULL, 'Libros y Revistas', 'libros-revistas', 'Publicaciones sobre inclusiÃ³n, arte y el mensaje de Cami', NULL, 'bi bi-book', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(11, 1, 'Dibujos y Bocetos', 'dibujos-bocetos', 'Bocetos originales a la venta', NULL, 'bi bi-pencil', 0, 1, 0, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:11:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nit` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `email` varchar(266) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `web` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `nombre`, `nit`, `direccion`, `telefono`, `logo`, `email`, `ciudad`, `web`) VALUES
(1, 'Poliandino', '8909852335', 'Calle 56 # 41-155 (Bolivia con Girardot)', '604 540 0779', 'logo_1780085533.png', '', 'MedellÃ¯n', 'https://www.poliandino.edu.co/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` enum('new','read','replied','closed') NOT NULL DEFAULT 'new',
  `reply` text DEFAULT NULL,
  `replied_by` int(11) DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `code` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('percentage','fixed_cart','fixed_product','free_shipping') NOT NULL DEFAULT 'percentage',
  `value` decimal(12,2) NOT NULL COMMENT 'Porcentaje o monto fijo',
  `min_order_amount` decimal(12,2) DEFAULT NULL COMMENT 'Monto m??nimo de pedido',
  `max_discount_amount` decimal(12,2) DEFAULT NULL COMMENT 'Descuento m??ximo (para %)',
  `usage_limit` int(11) DEFAULT NULL COMMENT 'NULL = sin l??mite',
  `usage_limit_per_customer` int(11) DEFAULT 1,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `applies_to` enum('all','categories','products') NOT NULL DEFAULT 'all',
  `applicable_ids` text DEFAULT NULL COMMENT 'IDs de categor??as o productos (JSON)',
  `exclude_sale_items` tinyint(1) NOT NULL DEFAULT 0,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coupon_usage`
--

CREATE TABLE `coupon_usage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `coupon_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `document_type` enum('CC','CE','TI','NIT','PP','PEP') NOT NULL DEFAULT 'CC',
  `document_number` varchar(20) DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification_token` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `newsletter_subscribed` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `customer_id` int(11) NOT NULL,
  `label` varchar(50) DEFAULT 'Casa' COMMENT 'Ej: Casa, Oficina, etc.',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `neighborhood` varchar(150) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address_detail` varchar(255) DEFAULT NULL COMMENT 'Apto, piso, torre, etc.',
  `postal_code` varchar(20) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `address_type` enum('shipping','billing','both') NOT NULL DEFAULT 'both',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_notifications`
--

CREATE TABLE `customer_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `customer_id` int(11) NOT NULL,
  `type` enum('order','payment','shipping','promotion','system','review') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(500) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_sessions`
--

CREATE TABLE `customer_sessions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `daily_sales_summary`
--

CREATE TABLE `daily_sales_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `date` date NOT NULL,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `total_items_sold` int(11) NOT NULL DEFAULT 0,
  `gross_sales` decimal(14,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `shipping_total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `tax_total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `net_sales` decimal(14,2) NOT NULL DEFAULT 0.00,
  `refund_total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `new_customers` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(10) UNSIGNED NOT NULL,
  `departamento` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `departamento`) VALUES
(5, 'ANTIOQUIA'),
(8, 'ATLÃNTICO'),
(11, 'BOGOTÃ, D.C.'),
(13, 'BOLÃVAR'),
(15, 'BOYACÃ'),
(17, 'CALDAS'),
(18, 'CAQUETÃ'),
(19, 'CAUCA'),
(20, 'CESAR'),
(23, 'CÃ“RDOBA'),
(25, 'CUNDINAMARCA'),
(27, 'CHOCÃ“'),
(41, 'HUILA'),
(44, 'LA GUAJIRA'),
(47, 'MAGDALENA'),
(50, 'META'),
(52, 'NARIÃ‘O'),
(54, 'NORTE DE SANTANDER'),
(63, 'QUINDIO'),
(66, 'RISARALDA'),
(68, 'SANTANDER'),
(70, 'SUCRE'),
(73, 'TOLIMA'),
(76, 'VALLE DEL CAUCA'),
(81, 'ARAUCA'),
(85, 'CASANARE'),
(86, 'PUTUMAYO'),
(88, 'ARCHIPIÃ‰LAGO DE SAN ANDRÃ‰S, PROVIDENCIA Y SANTA CATALINA'),
(91, 'AMAZONAS'),
(94, 'GUAINÃA'),
(95, 'GUAVIARE'),
(97, 'VAUPÃ‰S'),
(99, 'VICHADA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_history`
--

CREATE TABLE `email_history` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `recipients_count` int(11) NOT NULL,
  `successful_count` int(11) NOT NULL,
  `failed_count` int(11) NOT NULL,
  `sent_by` varchar(100) NOT NULL,
  `sent_from` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_recipients`
--

CREATE TABLE `email_recipients` (
  `id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `error_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `megapagos_config`
--

CREATE TABLE `megapagos_config` (
  `id` int(11) NOT NULL,
  `api_user` varchar(100) NOT NULL COMMENT 'Usuario/email del comercio en MEGAPAGOS',
  `api_pass` varchar(255) NOT NULL COMMENT 'Contrasena del comercio en MEGAPAGOS',
  `test_mode` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=QA, 0=Produccion',
  `base_url_qa` varchar(255) NOT NULL DEFAULT 'https://qaapi.megapagos.co:50443' COMMENT 'URL base entorno QA',
  `base_url_prod` varchar(255) NOT NULL DEFAULT 'https://api.megapagos.co' COMMENT 'URL base entorno produccion',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `megapagos_config`
--

INSERT INTO `megapagos_config` (`id`, `api_user`, `api_pass`, `test_mode`, `base_url_qa`, `base_url_prod`, `created_at`, `updated_at`) VALUES
(1, '', '', 1, 'https://qaapi.megapagos.co:50443', 'https://api.megapagos.co', '2026-07-07 00:00:00', '2026-07-07 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_config`
--

CREATE TABLE `envio_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `valor` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Valor del envio en COP',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `envio_config` (`id`, `valor`, `updated_at`) VALUES
(1, 15000.00, '2026-07-07 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_correos`
--

CREATE TABLE `historial_correos` (
  `id` int(11) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_log`
--

CREATE TABLE `inventory_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `type` enum('purchase','sale','return','adjustment','transfer') NOT NULL,
  `quantity_change` int(11) NOT NULL COMMENT 'Positivo=entrada, Negativo=salida',
  `stock_before` int(11) NOT NULL,
  `stock_after` int(11) NOT NULL,
  `reference_type` varchar(50) DEFAULT NULL COMMENT 'order, return, manual, etc.',
  `reference_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(10) UNSIGNED NOT NULL,
  `municipio` varchar(255) NOT NULL DEFAULT '',
  `estado` int(10) UNSIGNED NOT NULL,
  `departamento_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `municipio`, `estado`, `departamento_id`) VALUES
(1, 'AbriaquÃ­', 1, 5),
(2, 'AcacÃ­as', 1, 50),
(3, 'AcandÃ­', 1, 27),
(4, 'Acevedo', 1, 41),
(5, 'AchÃ­', 1, 13),
(6, 'Agrado', 1, 41),
(7, 'Agua de Dios', 1, 25),
(8, 'Aguachica', 1, 20),
(9, 'Aguada', 1, 68),
(10, 'Aguadas', 1, 17),
(11, 'Aguazul', 1, 85),
(12, 'AgustÃ­n Codazzi', 1, 20),
(13, 'Aipe', 1, 41),
(14, 'Albania', 1, 18),
(15, 'Albania', 1, 44),
(16, 'Albania', 1, 68),
(17, 'AlbÃ¡n', 1, 25),
(18, 'AlbÃ¡n (San JosÃ©)', 1, 52),
(19, 'AlcalÃ¡', 1, 76),
(20, 'Alejandria', 1, 5),
(21, 'Algarrobo', 1, 47),
(22, 'Algeciras', 1, 41),
(23, 'Almaguer', 1, 19),
(24, 'Almeida', 1, 15),
(25, 'Alpujarra', 1, 73),
(26, 'Altamira', 1, 41),
(27, 'Alto BaudÃ³ (Pie de Pato)', 1, 27),
(28, 'Altos del Rosario', 1, 13),
(29, 'Alvarado', 1, 73),
(30, 'AmagÃ¡', 1, 5),
(31, 'Amalfi', 1, 5),
(32, 'Ambalema', 1, 73),
(33, 'Anapoima', 1, 25),
(34, 'Ancuya', 1, 52),
(35, 'AndalucÃ­a', 1, 76),
(36, 'Andes', 1, 5),
(37, 'AngelÃ³polis', 1, 5),
(38, 'Angostura', 1, 5),
(39, 'Anolaima', 1, 25),
(40, 'AnorÃ­', 1, 5),
(41, 'Anserma', 1, 17),
(42, 'Ansermanuevo', 1, 76),
(43, 'AnzoÃ¡tegui', 1, 73),
(44, 'AnzÃ¡', 1, 5),
(45, 'ApartadÃ³', 1, 5),
(46, 'Apulo', 1, 25),
(47, 'ApÃ­a', 1, 66),
(48, 'Aquitania', 1, 15),
(49, 'Aracataca', 1, 47),
(50, 'Aranzazu', 1, 17),
(51, 'Aratoca', 1, 68),
(52, 'Arauca', 1, 81),
(53, 'Arauquita', 1, 81),
(54, 'ArbelÃ¡ez', 1, 25),
(55, 'Arboleda (Berruecos)', 1, 52),
(56, 'Arboledas', 1, 54),
(57, 'Arboletes', 1, 5),
(58, 'Arcabuco', 1, 15),
(59, 'Arenal', 1, 13),
(60, 'Argelia', 1, 5),
(61, 'Argelia', 1, 19),
(62, 'Argelia', 1, 76),
(63, 'AriguanÃ­ (El DifÃ­cil)', 1, 47),
(64, 'Arjona', 1, 13),
(65, 'Armenia', 1, 5),
(66, 'Armenia', 1, 63),
(67, 'Armero (Guayabal)', 1, 73),
(68, 'Arroyohondo', 1, 13),
(69, 'Astrea', 1, 20),
(70, 'Ataco', 1, 73),
(71, 'Atrato (Yuto)', 1, 27),
(72, 'Ayapel', 1, 23),
(73, 'BagadÃ³', 1, 27),
(74, 'BahÃ­a Solano (MÃºtis)', 1, 27),
(75, 'Bajo BaudÃ³ (Pizarro)', 1, 27),
(76, 'Balboa', 1, 19),
(77, 'Balboa', 1, 66),
(78, 'Baranoa', 1, 8),
(79, 'Baraya', 1, 41),
(80, 'Barbacoas', 1, 52),
(81, 'Barbosa', 1, 5),
(82, 'Barbosa', 1, 68),
(83, 'Barichara', 1, 68),
(84, 'Barranca de UpÃ­a', 1, 50),
(85, 'Barrancabermeja', 1, 68),
(86, 'Barrancas', 1, 44),
(87, 'Barranco de Loba', 1, 13),
(88, 'Barranquilla', 1, 8),
(89, 'BecerrÃ­l', 1, 20),
(90, 'BelalcÃ¡zar', 1, 17),
(91, 'Bello', 1, 5),
(92, 'Belmira', 1, 5),
(93, 'BeltrÃ¡n', 1, 25),
(94, 'BelÃ©n', 1, 15),
(95, 'BelÃ©n', 1, 52),
(96, 'BelÃ©n de BajirÃ¡', 1, 27),
(97, 'BelÃ©n de UmbrÃ­a', 1, 66),
(98, 'BelÃ©n de los AndaquÃ­es', 1, 18),
(99, 'Berbeo', 1, 15),
(100, 'Betania', 1, 5),
(101, 'Beteitiva', 1, 15),
(102, 'Betulia', 1, 5),
(103, 'Betulia', 1, 68),
(104, 'Bituima', 1, 25),
(105, 'Boavita', 1, 15),
(106, 'Bochalema', 1, 54),
(107, 'BogotÃ¡ D.C.', 1, 11),
(108, 'BojacÃ¡', 1, 25),
(109, 'BojayÃ¡ (Bellavista)', 1, 27),
(110, 'BolÃ­var', 1, 5),
(111, 'BolÃ­var', 1, 19),
(112, 'BolÃ­var', 1, 68),
(113, 'BolÃ­var', 1, 76),
(114, 'Bosconia', 1, 20),
(115, 'BoyacÃ¡', 1, 15),
(116, 'BriceÃ±o', 1, 5),
(117, 'BriceÃ±o', 1, 15),
(118, 'Bucaramanga', 1, 68),
(119, 'Bucarasica', 1, 54),
(120, 'Buenaventura', 1, 76),
(121, 'Buenavista', 1, 15),
(122, 'Buenavista', 1, 23),
(123, 'Buenavista', 1, 63),
(124, 'Buenavista', 1, 70),
(125, 'Buenos Aires', 1, 19),
(126, 'Buesaco', 1, 52),
(127, 'Buga', 1, 76),
(128, 'Bugalagrande', 1, 76),
(129, 'BurÃ­tica', 1, 5),
(130, 'Busbanza', 1, 15),
(131, 'Cabrera', 1, 25),
(132, 'Cabrera', 1, 68),
(133, 'Cabuyaro', 1, 50),
(134, 'Cachipay', 1, 25),
(135, 'Caicedo', 1, 5),
(136, 'Caicedonia', 1, 76),
(137, 'Caimito', 1, 70),
(138, 'Cajamarca', 1, 73),
(139, 'CajibÃ­o', 1, 19),
(140, 'CajicÃ¡', 1, 25),
(141, 'Calamar', 1, 13),
(142, 'Calamar', 1, 95),
(143, 'CalarcÃ¡', 1, 63),
(144, 'Caldas', 1, 5),
(145, 'Caldas', 1, 15),
(146, 'Caldono', 1, 19),
(147, 'California', 1, 68),
(148, 'Calima (DariÃ©n)', 1, 76),
(149, 'Caloto', 1, 19),
(150, 'CalÃ­', 1, 76),
(151, 'Campamento', 1, 5),
(152, 'Campo de la Cruz', 1, 8),
(153, 'Campoalegre', 1, 41),
(154, 'Campohermoso', 1, 15),
(155, 'Canalete', 1, 23),
(156, 'Candelaria', 1, 8),
(157, 'Candelaria', 1, 76),
(158, 'Cantagallo', 1, 13),
(159, 'CantÃ³n de San Pablo', 1, 27),
(160, 'CaparrapÃ­', 1, 25),
(161, 'Capitanejo', 1, 68),
(162, 'CaracolÃ­', 1, 5),
(163, 'Caramanta', 1, 5),
(164, 'CarcasÃ­', 1, 68),
(165, 'Carepa', 1, 5),
(166, 'Carmen de ApicalÃ¡', 1, 73),
(167, 'Carmen de Carupa', 1, 25),
(168, 'Carmen de Viboral', 1, 5),
(169, 'Carmen del DariÃ©n (CURBARADÃ“)', 1, 27),
(170, 'Carolina', 1, 5),
(171, 'Cartagena', 1, 13),
(172, 'Cartagena del ChairÃ¡', 1, 18),
(173, 'Cartago', 1, 76),
(174, 'CarurÃº', 1, 97),
(175, 'Casabianca', 1, 73),
(176, 'Castilla la Nueva', 1, 50),
(177, 'Caucasia', 1, 5),
(178, 'CaÃ±asgordas', 1, 5),
(179, 'Cepita', 1, 68),
(180, 'CeretÃ©', 1, 23),
(181, 'Cerinza', 1, 15),
(182, 'Cerrito', 1, 68),
(183, 'Cerro San Antonio', 1, 47),
(184, 'ChachaguÃ­', 1, 52),
(185, 'ChaguanÃ­', 1, 25),
(186, 'ChalÃ¡n', 1, 70),
(187, 'Chaparral', 1, 73),
(188, 'CharalÃ¡', 1, 68),
(189, 'Charta', 1, 68),
(190, 'ChigorodÃ³', 1, 5),
(191, 'Chima', 1, 68),
(192, 'Chimichagua', 1, 20),
(193, 'ChimÃ¡', 1, 23),
(194, 'Chinavita', 1, 15),
(195, 'ChinchinÃ¡', 1, 17),
(196, 'ChinÃ¡cota', 1, 54),
(197, 'ChinÃº', 1, 23),
(198, 'Chipaque', 1, 25),
(199, 'ChipatÃ¡', 1, 68),
(200, 'ChiquinquirÃ¡', 1, 15),
(201, 'ChiriguanÃ¡', 1, 20),
(202, 'Chiscas', 1, 15),
(203, 'Chita', 1, 15),
(204, 'ChitagÃ¡', 1, 54),
(205, 'Chitaraque', 1, 15),
(206, 'ChivatÃ¡', 1, 15),
(207, 'Chivolo', 1, 47),
(208, 'ChoachÃ­', 1, 25),
(209, 'ChocontÃ¡', 1, 25),
(210, 'ChÃ¡meza', 1, 85),
(211, 'ChÃ­a', 1, 25),
(212, 'ChÃ­quiza', 1, 15),
(213, 'ChÃ­vor', 1, 15),
(214, 'Cicuco', 1, 13),
(215, 'Cimitarra', 1, 68),
(216, 'Circasia', 1, 63),
(217, 'Cisneros', 1, 5),
(218, 'CiÃ©naga', 1, 15),
(219, 'CiÃ©naga', 1, 47),
(220, 'CiÃ©naga de Oro', 1, 23),
(221, 'Clemencia', 1, 13),
(222, 'CocornÃ¡', 1, 5),
(223, 'Coello', 1, 73),
(224, 'Cogua', 1, 25),
(225, 'Colombia', 1, 41),
(226, 'ColosÃ³ (Ricaurte)', 1, 70),
(227, 'ColÃ³n', 1, 86),
(228, 'ColÃ³n (GÃ©nova)', 1, 52),
(229, 'ConcepciÃ³n', 1, 5),
(230, 'ConcepciÃ³n', 1, 68),
(231, 'Concordia', 1, 5),
(232, 'Concordia', 1, 47),
(233, 'Condoto', 1, 27),
(234, 'Confines', 1, 68),
(235, 'Consaca', 1, 52),
(236, 'Contadero', 1, 52),
(237, 'ContrataciÃ³n', 1, 68),
(238, 'ConvenciÃ³n', 1, 54),
(239, 'Copacabana', 1, 5),
(240, 'Coper', 1, 15),
(241, 'CordobÃ¡', 1, 63),
(242, 'Corinto', 1, 19),
(243, 'Coromoro', 1, 68),
(244, 'Corozal', 1, 70),
(245, 'Corrales', 1, 15),
(246, 'Cota', 1, 25),
(247, 'Cotorra', 1, 23),
(248, 'CovarachÃ­a', 1, 15),
(249, 'CoveÃ±as', 1, 70),
(250, 'Coyaima', 1, 73),
(251, 'Cravo Norte', 1, 81),
(252, 'Cuaspud (Carlosama)', 1, 52),
(253, 'Cubarral', 1, 50),
(254, 'CubarÃ¡', 1, 15),
(255, 'Cucaita', 1, 15),
(256, 'CucunubÃ¡', 1, 25),
(257, 'Cucutilla', 1, 54),
(258, 'Cuitiva', 1, 15),
(259, 'Cumaral', 1, 50),
(260, 'Cumaribo', 1, 99),
(261, 'Cumbal', 1, 52),
(262, 'Cumbitara', 1, 52),
(263, 'Cunday', 1, 73),
(264, 'Curillo', 1, 18),
(265, 'CuritÃ­', 1, 68),
(266, 'CurumanÃ­', 1, 20),
(267, 'CÃ¡ceres', 1, 5),
(268, 'CÃ¡chira', 1, 54),
(269, 'CÃ¡cota', 1, 54),
(270, 'CÃ¡queza', 1, 25),
(271, 'CÃ©rtegui', 1, 27),
(272, 'CÃ³mbita', 1, 15),
(273, 'CÃ³rdoba', 1, 13),
(274, 'CÃ³rdoba', 1, 52),
(275, 'CÃºcuta', 1, 54),
(276, 'Dabeiba', 1, 5),
(277, 'Dagua', 1, 76),
(278, 'Dibulla', 1, 44),
(279, 'DistracciÃ³n', 1, 44),
(280, 'Dolores', 1, 73),
(281, 'Don MatÃ­as', 1, 5),
(282, 'Dos Quebradas', 1, 66),
(283, 'Duitama', 1, 15),
(284, 'Durania', 1, 54),
(285, 'EbÃ©jico', 1, 5),
(286, 'El Bagre', 1, 5),
(287, 'El Banco', 1, 47),
(288, 'El Cairo', 1, 76),
(289, 'El Calvario', 1, 50),
(290, 'El Carmen', 1, 54),
(291, 'El Carmen', 1, 68),
(292, 'El Carmen de Atrato', 1, 27),
(293, 'El Carmen de BolÃ­var', 1, 13),
(294, 'El Castillo', 1, 50),
(295, 'El Cerrito', 1, 76),
(296, 'El Charco', 1, 52),
(297, 'El Cocuy', 1, 15),
(298, 'El Colegio', 1, 25),
(299, 'El Copey', 1, 20),
(300, 'El Doncello', 1, 18),
(301, 'El Dorado', 1, 50),
(302, 'El Dovio', 1, 76),
(303, 'El Espino', 1, 15),
(304, 'El Guacamayo', 1, 68),
(305, 'El Guamo', 1, 13),
(306, 'El Molino', 1, 44),
(307, 'El Paso', 1, 20),
(308, 'El Paujil', 1, 18),
(309, 'El PeÃ±ol', 1, 52),
(310, 'El PeÃ±on', 1, 13),
(311, 'El PeÃ±on', 1, 68),
(312, 'El PeÃ±Ã³n', 1, 25),
(313, 'El PiÃ±on', 1, 47),
(314, 'El PlayÃ³n', 1, 68),
(315, 'El Retorno', 1, 95),
(316, 'El RetÃ©n', 1, 47),
(317, 'El Roble', 1, 70),
(318, 'El Rosal', 1, 25),
(319, 'El Rosario', 1, 52),
(320, 'El TablÃ³n de GÃ³mez', 1, 52),
(321, 'El Tambo', 1, 19),
(322, 'El Tambo', 1, 52),
(323, 'El Tarra', 1, 54),
(324, 'El Zulia', 1, 54),
(325, 'El Ãguila', 1, 76),
(326, 'ElÃ­as', 1, 41),
(327, 'Encino', 1, 68),
(328, 'Enciso', 1, 68),
(329, 'EntrerrÃ­os', 1, 5),
(330, 'Envigado', 1, 5),
(331, 'Espinal', 1, 73),
(332, 'FacatativÃ¡', 1, 25),
(333, 'Falan', 1, 73),
(334, 'Filadelfia', 1, 17),
(335, 'Filandia', 1, 63),
(336, 'Firavitoba', 1, 15),
(337, 'Flandes', 1, 73),
(338, 'Florencia', 1, 18),
(339, 'Florencia', 1, 19),
(340, 'Floresta', 1, 15),
(341, 'Florida', 1, 76),
(342, 'Floridablanca', 1, 68),
(343, 'FloriÃ¡n', 1, 68),
(344, 'Fonseca', 1, 44),
(345, 'FortÃºl', 1, 81),
(346, 'Fosca', 1, 25),
(347, 'Francisco Pizarro', 1, 52),
(348, 'Fredonia', 1, 5),
(349, 'Fresno', 1, 73),
(350, 'Frontino', 1, 5),
(351, 'Fuente de Oro', 1, 50),
(352, 'FundaciÃ³n', 1, 47),
(353, 'Funes', 1, 52),
(354, 'Funza', 1, 25),
(355, 'FusagasugÃ¡', 1, 25),
(356, 'FÃ³meque', 1, 25),
(357, 'FÃºquene', 1, 25),
(358, 'GachalÃ¡', 1, 25),
(359, 'GachancipÃ¡', 1, 25),
(360, 'GachantivÃ¡', 1, 15),
(361, 'GachetÃ¡', 1, 25),
(362, 'Galapa', 1, 8),
(363, 'Galeras (Nueva Granada)', 1, 70),
(364, 'GalÃ¡n', 1, 68),
(365, 'Gama', 1, 25),
(366, 'Gamarra', 1, 20),
(367, 'Garagoa', 1, 15),
(368, 'GarzÃ³n', 1, 41),
(369, 'Gigante', 1, 41),
(370, 'Ginebra', 1, 76),
(371, 'Giraldo', 1, 5),
(372, 'Girardot', 1, 25),
(373, 'Girardota', 1, 5),
(374, 'GirÃ³n', 1, 68),
(375, 'Gonzalez', 1, 20),
(376, 'Gramalote', 1, 54),
(377, 'Granada', 1, 5),
(378, 'Granada', 1, 25),
(379, 'Granada', 1, 50),
(380, 'Guaca', 1, 68),
(381, 'Guacamayas', 1, 15),
(382, 'GuacarÃ­', 1, 76),
(383, 'GuachavÃ©s', 1, 52),
(384, 'GuachenÃ©', 1, 19),
(385, 'GuachetÃ¡', 1, 25),
(386, 'Guachucal', 1, 52),
(387, 'Guadalupe', 1, 5),
(388, 'Guadalupe', 1, 41),
(389, 'Guadalupe', 1, 68),
(390, 'Guaduas', 1, 25),
(391, 'Guaitarilla', 1, 52),
(392, 'GualmatÃ¡n', 1, 52),
(393, 'Guamal', 1, 47),
(394, 'Guamal', 1, 50),
(395, 'Guamo', 1, 73),
(396, 'Guapota', 1, 68),
(397, 'GuapÃ­', 1, 19),
(398, 'Guaranda', 1, 70),
(399, 'Guarne', 1, 5),
(400, 'Guasca', 1, 25),
(401, 'GuatapÃ©', 1, 5),
(402, 'GuataquÃ­', 1, 25),
(403, 'Guatavita', 1, 25),
(404, 'Guateque', 1, 15),
(405, 'GuavatÃ¡', 1, 68),
(406, 'Guayabal de Siquima', 1, 25),
(407, 'Guayabetal', 1, 25),
(408, 'GuayatÃ¡', 1, 15),
(409, 'Guepsa', 1, 68),
(410, 'GuicÃ¡n', 1, 15),
(411, 'GutiÃ©rrez', 1, 25),
(412, 'GuÃ¡tica', 1, 66),
(413, 'GÃ¡mbita', 1, 68),
(414, 'GÃ¡meza', 1, 15),
(415, 'GÃ©nova', 1, 63),
(416, 'GÃ³mez Plata', 1, 5),
(417, 'HacarÃ­', 1, 54),
(418, 'Hatillo de Loba', 1, 13),
(419, 'Hato', 1, 68),
(420, 'Hato Corozal', 1, 85),
(421, 'Hatonuevo', 1, 44),
(422, 'Heliconia', 1, 5),
(423, 'HerrÃ¡n', 1, 54),
(424, 'Herveo', 1, 73),
(425, 'Hispania', 1, 5),
(426, 'Hobo', 1, 41),
(427, 'Honda', 1, 73),
(428, 'IbaguÃ©', 1, 73),
(429, 'Icononzo', 1, 73),
(430, 'Iles', 1, 52),
(431, 'ImÃºes', 1, 52),
(432, 'InzÃ¡', 1, 19),
(433, 'InÃ­rida', 1, 94),
(434, 'Ipiales', 1, 52),
(435, 'Isnos', 1, 41),
(436, 'Istmina', 1, 27),
(437, 'ItagÃ¼Ã­', 1, 5),
(438, 'Ituango', 1, 5),
(439, 'IzÃ¡', 1, 15),
(440, 'JambalÃ³', 1, 19),
(441, 'JamundÃ­', 1, 76),
(442, 'JardÃ­n', 1, 5),
(443, 'Jenesano', 1, 15),
(444, 'JericÃ³', 1, 5),
(445, 'JericÃ³', 1, 15),
(446, 'JerusalÃ©n', 1, 25),
(447, 'JesÃºs MarÃ­a', 1, 68),
(448, 'JordÃ¡n', 1, 68),
(449, 'Juan de Acosta', 1, 8),
(450, 'JunÃ­n', 1, 25),
(451, 'JuradÃ³', 1, 27),
(452, 'La Apartada y La Frontera', 1, 23),
(453, 'La Argentina', 1, 41),
(454, 'La Belleza', 1, 68),
(455, 'La Calera', 1, 25),
(456, 'La Capilla', 1, 15),
(457, 'La Ceja', 1, 5),
(458, 'La Celia', 1, 66),
(459, 'La Cruz', 1, 52),
(460, 'La Cumbre', 1, 76),
(461, 'La Dorada', 1, 17),
(462, 'La Esperanza', 1, 54),
(463, 'La Estrella', 1, 5),
(464, 'La Florida', 1, 52),
(465, 'La Gloria', 1, 20),
(466, 'La Jagua de Ibirico', 1, 20),
(467, 'La Jagua del Pilar', 1, 44),
(468, 'La Llanada', 1, 52),
(469, 'La Macarena', 1, 50),
(470, 'La Merced', 1, 17),
(471, 'La Mesa', 1, 25),
(472, 'La MontaÃ±ita', 1, 18),
(473, 'La Palma', 1, 25),
(474, 'La Paz', 1, 68),
(475, 'La Paz (Robles)', 1, 20),
(476, 'La PeÃ±a', 1, 25),
(477, 'La Pintada', 1, 5),
(478, 'La Plata', 1, 41),
(479, 'La Playa', 1, 54),
(480, 'La Primavera', 1, 99),
(481, 'La Salina', 1, 85),
(482, 'La Sierra', 1, 19),
(483, 'La Tebaida', 1, 63),
(484, 'La Tola', 1, 52),
(485, 'La UniÃ³n', 1, 5),
(486, 'La UniÃ³n', 1, 52),
(487, 'La UniÃ³n', 1, 70),
(488, 'La UniÃ³n', 1, 76),
(489, 'La Uvita', 1, 15),
(490, 'La Vega', 1, 19),
(491, 'La Vega', 1, 25),
(492, 'La Victoria', 1, 15),
(493, 'La Victoria', 1, 17),
(494, 'La Victoria', 1, 76),
(495, 'La Virginia', 1, 66),
(496, 'Labateca', 1, 54),
(497, 'Labranzagrande', 1, 15),
(498, 'LandÃ¡zuri', 1, 68),
(499, 'Lebrija', 1, 68),
(500, 'Leiva', 1, 52),
(501, 'LejanÃ­as', 1, 50),
(502, 'Lenguazaque', 1, 25),
(503, 'Leticia', 1, 91),
(504, 'Liborina', 1, 5),
(505, 'Linares', 1, 52),
(506, 'LlorÃ³', 1, 27),
(507, 'Lorica', 1, 23),
(508, 'Los CÃ³rdobas', 1, 23),
(509, 'Los Palmitos', 1, 70),
(510, 'Los Patios', 1, 54),
(511, 'Los Santos', 1, 68),
(512, 'Lourdes', 1, 54),
(513, 'Luruaco', 1, 8),
(514, 'LÃ©rida', 1, 73),
(515, 'LÃ­bano', 1, 73),
(516, 'LÃ³pez (Micay)', 1, 19),
(517, 'Macanal', 1, 15),
(518, 'Macaravita', 1, 68),
(519, 'Maceo', 1, 5),
(520, 'MachetÃ¡', 1, 25),
(521, 'Madrid', 1, 25),
(522, 'MaganguÃ©', 1, 13),
(523, 'MagÃ¼i (PayÃ¡n)', 1, 52),
(524, 'Mahates', 1, 13),
(525, 'Maicao', 1, 44),
(526, 'Majagual', 1, 70),
(527, 'Malambo', 1, 8),
(528, 'Mallama (Piedrancha)', 1, 52),
(529, 'ManatÃ­', 1, 8),
(530, 'Manaure', 1, 44),
(531, 'Manaure BalcÃ³n del Cesar', 1, 20),
(532, 'Manizales', 1, 17),
(533, 'Manta', 1, 25),
(534, 'Manzanares', 1, 17),
(535, 'ManÃ­', 1, 85),
(536, 'Mapiripan', 1, 50),
(537, 'Margarita', 1, 13),
(538, 'Marinilla', 1, 5),
(539, 'MaripÃ­', 1, 15),
(540, 'Mariquita', 1, 73),
(541, 'Marmato', 1, 17),
(542, 'Marquetalia', 1, 17),
(543, 'Marsella', 1, 66),
(544, 'Marulanda', 1, 17),
(545, 'MarÃ­a la Baja', 1, 13),
(546, 'Matanza', 1, 68),
(547, 'MedellÃ­n', 1, 5),
(548, 'Medina', 1, 25),
(549, 'Medio Atrato', 1, 27),
(550, 'Medio BaudÃ³', 1, 27),
(551, 'Medio San Juan (ANDAGOYA)', 1, 27),
(552, 'Melgar', 1, 73),
(553, 'Mercaderes', 1, 19),
(554, 'Mesetas', 1, 50),
(555, 'MilÃ¡n', 1, 18),
(556, 'Miraflores', 1, 15),
(557, 'Miraflores', 1, 95),
(558, 'Miranda', 1, 19),
(559, 'MistratÃ³', 1, 66),
(560, 'MitÃº', 1, 97),
(561, 'Mocoa', 1, 86),
(562, 'Mogotes', 1, 68),
(563, 'Molagavita', 1, 68),
(564, 'Momil', 1, 23),
(565, 'MompÃ³s', 1, 13),
(566, 'Mongua', 1, 15),
(567, 'MonguÃ­', 1, 15),
(568, 'MoniquirÃ¡', 1, 15),
(569, 'Montebello', 1, 5),
(570, 'Montecristo', 1, 13),
(571, 'MontelÃ­bano', 1, 23),
(572, 'Montenegro', 1, 63),
(573, 'Monteria', 1, 23),
(574, 'Monterrey', 1, 85),
(575, 'Morales', 1, 13),
(576, 'Morales', 1, 19),
(577, 'Morelia', 1, 18),
(578, 'Morroa', 1, 70),
(579, 'Mosquera', 1, 25),
(580, 'Mosquera', 1, 52),
(581, 'Motavita', 1, 15),
(582, 'MoÃ±itos', 1, 23),
(583, 'Murillo', 1, 73),
(584, 'MurindÃ³', 1, 5),
(585, 'MutatÃ¡', 1, 5),
(586, 'Mutiscua', 1, 54),
(587, 'Muzo', 1, 15),
(588, 'MÃ¡laga', 1, 68),
(589, 'NariÃ±o', 1, 5),
(590, 'NariÃ±o', 1, 25),
(591, 'NariÃ±o', 1, 52),
(592, 'Natagaima', 1, 73),
(593, 'NechÃ­', 1, 5),
(594, 'NecoclÃ­', 1, 5),
(595, 'Neira', 1, 17),
(596, 'Neiva', 1, 41),
(597, 'NemocÃ³n', 1, 25),
(598, 'Nilo', 1, 25),
(599, 'Nimaima', 1, 25),
(600, 'Nobsa', 1, 15),
(601, 'Nocaima', 1, 25),
(602, 'Norcasia', 1, 17),
(603, 'NorosÃ­', 1, 13),
(604, 'Novita', 1, 27),
(605, 'Nueva Granada', 1, 47),
(606, 'Nuevo ColÃ³n', 1, 15),
(607, 'NunchÃ­a', 1, 85),
(608, 'NuquÃ­', 1, 27),
(609, 'NÃ¡taga', 1, 41),
(610, 'Obando', 1, 76),
(611, 'Ocamonte', 1, 68),
(612, 'OcaÃ±a', 1, 54),
(613, 'Oiba', 1, 68),
(614, 'OicatÃ¡', 1, 15),
(615, 'Olaya', 1, 5),
(616, 'Olaya Herrera', 1, 52),
(617, 'Onzaga', 1, 68),
(618, 'Oporapa', 1, 41),
(619, 'Orito', 1, 86),
(620, 'OrocuÃ©', 1, 85),
(621, 'Ortega', 1, 73),
(622, 'Ospina', 1, 52),
(623, 'Otanche', 1, 15),
(624, 'Ovejas', 1, 70),
(625, 'Pachavita', 1, 15),
(626, 'Pacho', 1, 25),
(627, 'Padilla', 1, 19),
(628, 'Paicol', 1, 41),
(629, 'Pailitas', 1, 20),
(630, 'Paime', 1, 25),
(631, 'Paipa', 1, 15),
(632, 'Pajarito', 1, 15),
(633, 'Palermo', 1, 41),
(634, 'Palestina', 1, 17),
(635, 'Palestina', 1, 41),
(636, 'Palmar', 1, 68),
(637, 'Palmar de Varela', 1, 8),
(638, 'Palmas del Socorro', 1, 68),
(639, 'Palmira', 1, 76),
(640, 'Palmito', 1, 70),
(641, 'Palocabildo', 1, 73),
(642, 'Pamplona', 1, 54),
(643, 'Pamplonita', 1, 54),
(644, 'Pandi', 1, 25),
(645, 'Panqueba', 1, 15),
(646, 'Paratebueno', 1, 25),
(647, 'Pasca', 1, 25),
(648, 'PatÃ­a (El Bordo)', 1, 19),
(649, 'Pauna', 1, 15),
(650, 'Paya', 1, 15),
(651, 'Paz de Ariporo', 1, 85),
(652, 'Paz de RÃ­o', 1, 15),
(653, 'Pedraza', 1, 47),
(654, 'Pelaya', 1, 20),
(655, 'Pensilvania', 1, 17),
(656, 'Peque', 1, 5),
(657, 'Pereira', 1, 66),
(658, 'Pesca', 1, 15),
(659, 'PeÃ±ol', 1, 5),
(660, 'Piamonte', 1, 19),
(661, 'Pie de Cuesta', 1, 68),
(662, 'Piedras', 1, 73),
(663, 'PiendamÃ³', 1, 19),
(664, 'Pijao', 1, 63),
(665, 'PijiÃ±o', 1, 47),
(666, 'Pinchote', 1, 68),
(667, 'Pinillos', 1, 13),
(668, 'Piojo', 1, 8),
(669, 'Pisva', 1, 15),
(670, 'Pital', 1, 41),
(671, 'Pitalito', 1, 41),
(672, 'Pivijay', 1, 47),
(673, 'Planadas', 1, 73),
(674, 'Planeta Rica', 1, 23),
(675, 'Plato', 1, 47),
(676, 'Policarpa', 1, 52),
(677, 'Polonuevo', 1, 8),
(678, 'Ponedera', 1, 8),
(679, 'PopayÃ¡n', 1, 19),
(680, 'Pore', 1, 85),
(681, 'PotosÃ­', 1, 52),
(682, 'Pradera', 1, 76),
(683, 'Prado', 1, 73),
(684, 'Providencia', 1, 52),
(685, 'Providencia', 1, 88),
(686, 'Pueblo Bello', 1, 20),
(687, 'Pueblo Nuevo', 1, 23),
(688, 'Pueblo Rico', 1, 66),
(689, 'Pueblorrico', 1, 5),
(690, 'Puebloviejo', 1, 47),
(691, 'Puente Nacional', 1, 68),
(692, 'Puerres', 1, 52),
(693, 'Puerto AsÃ­s', 1, 86),
(694, 'Puerto BerrÃ­o', 1, 5),
(695, 'Puerto BoyacÃ¡', 1, 15),
(696, 'Puerto Caicedo', 1, 86),
(697, 'Puerto CarreÃ±o', 1, 99),
(698, 'Puerto Colombia', 1, 8),
(699, 'Puerto Concordia', 1, 50),
(700, 'Puerto Escondido', 1, 23),
(701, 'Puerto GaitÃ¡n', 1, 50),
(702, 'Puerto GuzmÃ¡n', 1, 86),
(703, 'Puerto LeguÃ­zamo', 1, 86),
(704, 'Puerto Libertador', 1, 23),
(705, 'Puerto Lleras', 1, 50),
(706, 'Puerto LÃ³pez', 1, 50),
(707, 'Puerto Nare', 1, 5),
(708, 'Puerto NariÃ±o', 1, 91),
(709, 'Puerto Parra', 1, 68),
(710, 'Puerto Rico', 1, 18),
(711, 'Puerto Rico', 1, 50),
(712, 'Puerto RondÃ³n', 1, 81),
(713, 'Puerto Salgar', 1, 25),
(714, 'Puerto Santander', 1, 54),
(715, 'Puerto Tejada', 1, 19),
(716, 'Puerto Triunfo', 1, 5),
(717, 'Puerto Wilches', 1, 68),
(718, 'PulÃ­', 1, 25),
(719, 'Pupiales', 1, 52),
(720, 'PuracÃ© (Coconuco)', 1, 19),
(721, 'PurificaciÃ³n', 1, 73),
(722, 'PurÃ­sima', 1, 23),
(723, 'PÃ¡cora', 1, 17),
(724, 'PÃ¡ez', 1, 15),
(725, 'PÃ¡ez (Belalcazar)', 1, 19),
(726, 'PÃ¡ramo', 1, 68),
(727, 'Quebradanegra', 1, 25),
(728, 'Quetame', 1, 25),
(729, 'QuibdÃ³', 1, 27),
(730, 'Quimbaya', 1, 63),
(731, 'QuinchÃ­a', 1, 66),
(732, 'Quipama', 1, 15),
(733, 'Quipile', 1, 25),
(734, 'Ragonvalia', 1, 54),
(735, 'RamiriquÃ­', 1, 15),
(736, 'Recetor', 1, 85),
(737, 'Regidor', 1, 13),
(738, 'Remedios', 1, 5),
(739, 'Remolino', 1, 47),
(740, 'RepelÃ³n', 1, 8),
(741, 'Restrepo', 1, 50),
(742, 'Restrepo', 1, 76),
(743, 'Retiro', 1, 5),
(744, 'Ricaurte', 1, 25),
(745, 'Ricaurte', 1, 52),
(746, 'Rio Negro', 1, 68),
(747, 'Rioblanco', 1, 73),
(748, 'RiofrÃ­o', 1, 76),
(749, 'Riohacha', 1, 44),
(750, 'Risaralda', 1, 17),
(751, 'Rivera', 1, 41),
(752, 'Roberto PayÃ¡n (San JosÃ©)', 1, 52),
(753, 'Roldanillo', 1, 76),
(754, 'Roncesvalles', 1, 73),
(755, 'RondÃ³n', 1, 15),
(756, 'Rosas', 1, 19),
(757, 'Rovira', 1, 73),
(758, 'RÃ¡quira', 1, 15),
(759, 'RÃ­o IrÃ³', 1, 27),
(760, 'RÃ­o Quito', 1, 27),
(761, 'RÃ­o Sucio', 1, 17),
(762, 'RÃ­o Viejo', 1, 13),
(763, 'RÃ­o de oro', 1, 20),
(764, 'RÃ­onegro', 1, 5),
(765, 'RÃ­osucio', 1, 27),
(766, 'Sabana de Torres', 1, 68),
(767, 'Sabanagrande', 1, 8),
(768, 'Sabanalarga', 1, 5),
(769, 'Sabanalarga', 1, 8),
(770, 'Sabanalarga', 1, 85),
(771, 'Sabanas de San Angel (SAN ANGEL)', 1, 47),
(772, 'Sabaneta', 1, 5),
(773, 'SaboyÃ¡', 1, 15),
(774, 'SahagÃºn', 1, 23),
(775, 'Saladoblanco', 1, 41),
(776, 'Salamina', 1, 17),
(777, 'Salamina', 1, 47),
(778, 'Salazar', 1, 54),
(779, 'SaldaÃ±a', 1, 73),
(780, 'Salento', 1, 63),
(781, 'Salgar', 1, 5),
(782, 'SamacÃ¡', 1, 15),
(783, 'Samaniego', 1, 52),
(784, 'SamanÃ¡', 1, 17),
(785, 'SampuÃ©s', 1, 70),
(786, 'San AgustÃ­n', 1, 41),
(787, 'San Alberto', 1, 20),
(788, 'San AndrÃ©s', 1, 68),
(789, 'San AndrÃ©s Sotavento', 1, 23),
(790, 'San AndrÃ©s de CuerquÃ­a', 1, 5),
(791, 'San Antero', 1, 23),
(792, 'San Antonio', 1, 73),
(793, 'San Antonio de Tequendama', 1, 25),
(794, 'San Benito', 1, 68),
(795, 'San Benito Abad', 1, 70),
(796, 'San Bernardo', 1, 25),
(797, 'San Bernardo', 1, 52),
(798, 'San Bernardo del Viento', 1, 23),
(799, 'San Calixto', 1, 54),
(800, 'San Carlos', 1, 5),
(801, 'San Carlos', 1, 23),
(802, 'San Carlos de Guaroa', 1, 50),
(803, 'San Cayetano', 1, 25),
(804, 'San Cayetano', 1, 54),
(805, 'San Cristobal', 1, 13),
(806, 'San Diego', 1, 20),
(807, 'San Eduardo', 1, 15),
(808, 'San Estanislao', 1, 13),
(809, 'San Fernando', 1, 13),
(810, 'San Francisco', 1, 5),
(811, 'San Francisco', 1, 25),
(812, 'San Francisco', 1, 86),
(813, 'San GÃ­l', 1, 68),
(814, 'San Jacinto', 1, 13),
(815, 'San Jacinto del Cauca', 1, 13),
(816, 'San JerÃ³nimo', 1, 5),
(817, 'San JoaquÃ­n', 1, 68),
(818, 'San JosÃ©', 1, 17),
(819, 'San JosÃ© de Miranda', 1, 68),
(820, 'San JosÃ© de MontaÃ±a', 1, 5),
(821, 'San JosÃ© de Pare', 1, 15),
(822, 'San JosÃ© de UrÃ©', 1, 23),
(823, 'San JosÃ© del Fragua', 1, 18),
(824, 'San JosÃ© del Guaviare', 1, 95),
(825, 'San JosÃ© del Palmar', 1, 27),
(826, 'San Juan de Arama', 1, 50),
(827, 'San Juan de Betulia', 1, 70),
(828, 'San Juan de Nepomuceno', 1, 13),
(829, 'San Juan de Pasto', 1, 52),
(830, 'San Juan de RÃ­o Seco', 1, 25),
(831, 'San Juan de UrabÃ¡', 1, 5),
(832, 'San Juan del Cesar', 1, 44),
(833, 'San Juanito', 1, 50),
(834, 'San Lorenzo', 1, 52),
(835, 'San Luis', 1, 73),
(836, 'San LuÃ­s', 1, 5),
(837, 'San LuÃ­s de Gaceno', 1, 15),
(838, 'San LuÃ­s de Palenque', 1, 85),
(839, 'San Marcos', 1, 70),
(840, 'San MartÃ­n', 1, 20),
(841, 'San MartÃ­n', 1, 50),
(842, 'San MartÃ­n de Loba', 1, 13),
(843, 'San Mateo', 1, 15),
(844, 'San Miguel', 1, 68),
(845, 'San Miguel', 1, 86),
(846, 'San Miguel de Sema', 1, 15),
(847, 'San Onofre', 1, 70),
(848, 'San Pablo', 1, 13),
(849, 'San Pablo', 1, 52),
(850, 'San Pablo de Borbur', 1, 15),
(851, 'San Pedro', 1, 5),
(852, 'San Pedro', 1, 70),
(853, 'San Pedro', 1, 76),
(854, 'San Pedro de Cartago', 1, 52),
(855, 'San Pedro de UrabÃ¡', 1, 5),
(856, 'San Pelayo', 1, 23),
(857, 'San Rafael', 1, 5),
(858, 'San Roque', 1, 5),
(859, 'San SebastiÃ¡n', 1, 19),
(860, 'San SebastiÃ¡n de Buenavista', 1, 47),
(861, 'San Vicente', 1, 5),
(862, 'San Vicente del CaguÃ¡n', 1, 18),
(863, 'San Vicente del ChucurÃ­', 1, 68),
(864, 'San ZenÃ³n', 1, 47),
(865, 'SandonÃ¡', 1, 52),
(866, 'Santa Ana', 1, 47),
(867, 'Santa BÃ¡rbara', 1, 5),
(868, 'Santa BÃ¡rbara', 1, 68),
(869, 'Santa BÃ¡rbara (IscuandÃ©)', 1, 52),
(870, 'Santa BÃ¡rbara de Pinto', 1, 47),
(871, 'Santa Catalina', 1, 13),
(872, 'Santa FÃ© de Antioquia', 1, 5),
(873, 'Santa Genoveva de DocorodÃ³', 1, 27),
(874, 'Santa Helena del OpÃ³n', 1, 68),
(875, 'Santa Isabel', 1, 73),
(876, 'Santa LucÃ­a', 1, 8),
(877, 'Santa Marta', 1, 47),
(878, 'Santa MarÃ­a', 1, 15),
(879, 'Santa MarÃ­a', 1, 41),
(880, 'Santa Rosa', 1, 13),
(881, 'Santa Rosa', 1, 19),
(882, 'Santa Rosa de Cabal', 1, 66),
(883, 'Santa Rosa de Osos', 1, 5),
(884, 'Santa Rosa de Viterbo', 1, 15),
(885, 'Santa Rosa del Sur', 1, 13),
(886, 'Santa RosalÃ­a', 1, 99),
(887, 'Santa SofÃ­a', 1, 15),
(888, 'Santana', 1, 15),
(889, 'Santander de Quilichao', 1, 19),
(890, 'Santiago', 1, 54),
(891, 'Santiago', 1, 86),
(892, 'Santo Domingo', 1, 5),
(893, 'Santo TomÃ¡s', 1, 8),
(894, 'Santuario', 1, 5),
(895, 'Santuario', 1, 66),
(896, 'Sapuyes', 1, 52),
(897, 'Saravena', 1, 81),
(898, 'Sardinata', 1, 54),
(899, 'Sasaima', 1, 25),
(900, 'Sativanorte', 1, 15),
(901, 'Sativasur', 1, 15),
(902, 'Segovia', 1, 5),
(903, 'SesquilÃ©', 1, 25),
(904, 'Sevilla', 1, 76),
(905, 'Siachoque', 1, 15),
(906, 'SibatÃ©', 1, 25),
(907, 'Sibundoy', 1, 86),
(908, 'Silos', 1, 54),
(909, 'Silvania', 1, 25),
(910, 'Silvia', 1, 19),
(911, 'Simacota', 1, 68),
(912, 'Simijaca', 1, 25),
(913, 'SimitÃ­', 1, 13),
(914, 'Sincelejo', 1, 70),
(915, 'SincÃ©', 1, 70),
(916, 'SipÃ­', 1, 27),
(917, 'Sitionuevo', 1, 47),
(918, 'Soacha', 1, 25),
(919, 'SoatÃ¡', 1, 15),
(920, 'Socha', 1, 15),
(921, 'Socorro', 1, 68),
(922, 'SocotÃ¡', 1, 15),
(923, 'Sogamoso', 1, 15),
(924, 'Solano', 1, 18),
(925, 'Soledad', 1, 8),
(926, 'Solita', 1, 18),
(927, 'Somondoco', 1, 15),
(928, 'SonsÃ³n', 1, 5),
(929, 'SopetrÃ¡n', 1, 5),
(930, 'Soplaviento', 1, 13),
(931, 'SopÃ³', 1, 25),
(932, 'Sora', 1, 15),
(933, 'SoracÃ¡', 1, 15),
(934, 'SotaquirÃ¡', 1, 15),
(935, 'Sotara (Paispamba)', 1, 19),
(936, 'Sotomayor (Los Andes)', 1, 52),
(937, 'Suaita', 1, 68),
(938, 'Suan', 1, 8),
(939, 'Suaza', 1, 41),
(940, 'Subachoque', 1, 25),
(941, 'Sucre', 1, 19),
(942, 'Sucre', 1, 68),
(943, 'Sucre', 1, 70),
(944, 'Suesca', 1, 25),
(945, 'SupatÃ¡', 1, 25),
(946, 'SupÃ­a', 1, 17),
(947, 'SuratÃ¡', 1, 68),
(948, 'Susa', 1, 25),
(949, 'SusacÃ³n', 1, 15),
(950, 'SutamarchÃ¡n', 1, 15),
(951, 'Sutatausa', 1, 25),
(952, 'Sutatenza', 1, 15),
(953, 'SuÃ¡rez', 1, 19),
(954, 'SuÃ¡rez', 1, 73),
(955, 'SÃ¡cama', 1, 85),
(956, 'SÃ¡chica', 1, 15),
(957, 'Tabio', 1, 25),
(958, 'TadÃ³', 1, 27),
(959, 'Talaigua Nuevo', 1, 13),
(960, 'Tamalameque', 1, 20),
(961, 'Tame', 1, 81),
(962, 'Taminango', 1, 52),
(963, 'Tangua', 1, 52),
(964, 'Taraira', 1, 97),
(965, 'TarazÃ¡', 1, 5),
(966, 'Tarqui', 1, 41),
(967, 'Tarso', 1, 5),
(968, 'Tasco', 1, 15),
(969, 'Tauramena', 1, 85),
(970, 'Tausa', 1, 25),
(971, 'Tello', 1, 41),
(972, 'Tena', 1, 25),
(973, 'Tenerife', 1, 47),
(974, 'Tenjo', 1, 25),
(975, 'Tenza', 1, 15),
(976, 'Teorama', 1, 54),
(977, 'Teruel', 1, 41),
(978, 'Tesalia', 1, 41),
(979, 'Tibacuy', 1, 25),
(980, 'TibanÃ¡', 1, 15),
(981, 'Tibasosa', 1, 15),
(982, 'Tibirita', 1, 25),
(983, 'TibÃº', 1, 54),
(984, 'Tierralta', 1, 23),
(985, 'TimanÃ¡', 1, 41),
(986, 'TimbiquÃ­', 1, 19),
(987, 'TimbÃ­o', 1, 19),
(988, 'TinjacÃ¡', 1, 15),
(989, 'Tipacoque', 1, 15),
(990, 'Tiquisio (Puerto Rico)', 1, 13),
(991, 'TitiribÃ­', 1, 5),
(992, 'Toca', 1, 15),
(993, 'Tocaima', 1, 25),
(994, 'TocancipÃ¡', 1, 25),
(995, 'ToguÃ­', 1, 15),
(996, 'Toledo', 1, 5),
(997, 'Toledo', 1, 54),
(998, 'TolÃº', 1, 70),
(999, 'TolÃº Viejo', 1, 70),
(1000, 'Tona', 1, 68),
(1001, 'TopagÃ¡', 1, 15),
(1002, 'TopaipÃ­', 1, 25),
(1003, 'ToribÃ­o', 1, 19),
(1004, 'Toro', 1, 76),
(1005, 'Tota', 1, 15),
(1006, 'TotorÃ³', 1, 19),
(1007, 'Trinidad', 1, 85),
(1008, 'Trujillo', 1, 76),
(1009, 'TubarÃ¡', 1, 8),
(1010, 'TuchÃ­n', 1, 23),
(1011, 'TulÃºa', 1, 76),
(1012, 'Tumaco', 1, 52),
(1013, 'Tunja', 1, 15),
(1014, 'Tunungua', 1, 15),
(1015, 'Turbaco', 1, 13),
(1016, 'TurbanÃ¡', 1, 13),
(1017, 'Turbo', 1, 5),
(1018, 'TurmequÃ©', 1, 15),
(1019, 'Tuta', 1, 15),
(1020, 'TutasÃ¡', 1, 15),
(1021, 'TÃ¡mara', 1, 85),
(1022, 'TÃ¡mesis', 1, 5),
(1023, 'TÃºquerres', 1, 52),
(1024, 'UbalÃ¡', 1, 25),
(1025, 'Ubaque', 1, 25),
(1026, 'UbatÃ©', 1, 25),
(1027, 'Ulloa', 1, 76),
(1028, 'Une', 1, 25),
(1029, 'UnguÃ­a', 1, 27),
(1030, 'UniÃ³n Panamericana (ÃNIMAS)', 1, 27),
(1031, 'Uramita', 1, 5),
(1032, 'Uribe', 1, 50),
(1033, 'Uribia', 1, 44),
(1034, 'Urrao', 1, 5),
(1035, 'Urumita', 1, 44),
(1036, 'Usiacuri', 1, 8),
(1037, 'Valdivia', 1, 5),
(1038, 'Valencia', 1, 23),
(1039, 'Valle de San JosÃ©', 1, 68),
(1040, 'Valle de San Juan', 1, 73),
(1041, 'Valle del Guamuez', 1, 86),
(1042, 'Valledupar', 1, 20),
(1043, 'Valparaiso', 1, 5),
(1044, 'Valparaiso', 1, 18),
(1045, 'VegachÃ­', 1, 5),
(1046, 'Venadillo', 1, 73),
(1047, 'Venecia', 1, 5),
(1048, 'Venecia (Ospina PÃ©rez)', 1, 25),
(1049, 'Ventaquemada', 1, 15),
(1050, 'Vergara', 1, 25),
(1051, 'Versalles', 1, 76),
(1052, 'Vetas', 1, 68),
(1053, 'Viani', 1, 25),
(1054, 'VigÃ­a del Fuerte', 1, 5),
(1055, 'Vijes', 1, 76),
(1056, 'Villa Caro', 1, 54),
(1057, 'Villa Rica', 1, 19),
(1058, 'Villa de Leiva', 1, 15),
(1059, 'Villa del Rosario', 1, 54),
(1060, 'VillagarzÃ³n', 1, 86),
(1061, 'VillagÃ³mez', 1, 25),
(1062, 'Villahermosa', 1, 73),
(1063, 'VillamarÃ­a', 1, 17),
(1064, 'Villanueva', 1, 13),
(1065, 'Villanueva', 1, 44),
(1066, 'Villanueva', 1, 68),
(1067, 'Villanueva', 1, 85),
(1068, 'VillapinzÃ³n', 1, 25),
(1069, 'Villarrica', 1, 73),
(1070, 'Villavicencio', 1, 50),
(1071, 'Villavieja', 1, 41),
(1072, 'Villeta', 1, 25),
(1073, 'ViotÃ¡', 1, 25),
(1074, 'ViracachÃ¡', 1, 15),
(1075, 'Vista Hermosa', 1, 50),
(1076, 'Viterbo', 1, 17),
(1077, 'VÃ©lez', 1, 68),
(1078, 'YacopÃ­', 1, 25),
(1079, 'Yacuanquer', 1, 52),
(1080, 'YaguarÃ¡', 1, 41),
(1081, 'YalÃ­', 1, 5),
(1082, 'Yarumal', 1, 5),
(1083, 'YolombÃ³', 1, 5),
(1084, 'YondÃ³ (Casabe)', 1, 5),
(1085, 'Yopal', 1, 85),
(1086, 'Yotoco', 1, 76),
(1087, 'Yumbo', 1, 76),
(1088, 'Zambrano', 1, 13),
(1089, 'Zapatoca', 1, 68),
(1090, 'ZapayÃ¡n (PUNTA DE PIEDRAS)', 1, 47),
(1091, 'Zaragoza', 1, 5),
(1092, 'Zarzal', 1, 76),
(1093, 'ZetaquirÃ¡', 1, 15),
(1094, 'ZipacÃ³n', 1, 25),
(1095, 'ZipaquirÃ¡', 1, 25),
(1096, 'Zona Bananera (PRADO - SEVILLA)', 1, 47),
(1097, 'Ãbrego', 1, 54),
(1098, 'Ãquira', 1, 41),
(1099, 'Ãšmbita', 1, 15),
(1100, 'Ãštica', 1, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `email` varchar(255) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `unsubscribed_at` datetime DEFAULT NULL,
  `source` varchar(50) DEFAULT 'website',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(30) NOT NULL COMMENT 'N??mero de pedido legible',
  `customer_id` int(11) DEFAULT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_document_type` varchar(20) DEFAULT NULL,
  `customer_document_number` varchar(20) DEFAULT NULL,
  `shipping_first_name` varchar(100) DEFAULT NULL,
  `shipping_last_name` varchar(100) DEFAULT NULL,
  `shipping_phone` varchar(20) DEFAULT NULL,
  `shipping_department` varchar(100) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_neighborhood` varchar(150) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_address_detail` varchar(255) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `billing_first_name` varchar(100) DEFAULT NULL,
  `billing_last_name` varchar(100) DEFAULT NULL,
  `billing_phone` varchar(20) DEFAULT NULL,
  `billing_department` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `billing_postal_code` varchar(20) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(5) NOT NULL DEFAULT 'COP',
  `status` enum('pending','confirmed','processing','shipped','delivered','completed','cancelled','refunded','failed') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','partially_refunded','refunded','failed','expired') NOT NULL DEFAULT 'pending',
  `shipping_status` enum('pending','preparing','shipped','in_transit','delivered','returned') NOT NULL DEFAULT 'pending',
  `shipping_method_id` int(11) DEFAULT NULL,
  `shipping_method_name` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `tracking_url` varchar(500) DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `customer_notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL COMMENT 'Nombre al momento de la compra',
  `variant_name` varchar(255) DEFAULT NULL,
  `sku` varchar(80) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_options` text DEFAULT NULL COMMENT 'Atributos seleccionados (JSON)',
  `is_reviewed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `old_status` varchar(30) DEFAULT NULL,
  `new_status` varchar(30) NOT NULL,
  `comment` text DEFAULT NULL,
  `notify_customer` tinyint(1) NOT NULL DEFAULT 0,
  `changed_by` varchar(100) DEFAULT NULL COMMENT 'Admin o sistema',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'T??rminos y Condiciones', 'terminos-y-condiciones', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24'),
(2, 'Pol??tica de Privacidad', 'politica-de-privacidad', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24'),
(3, 'Pol??tica de Devoluciones', 'politica-de-devoluciones', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24'),
(4, 'Pol??tica de Env??os', 'politica-de-envios', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24'),
(5, 'Preguntas Frecuentes', 'preguntas-frecuentes', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24'),
(6, 'Sobre Nosotros', 'sobre-nosotros', '', NULL, NULL, 1, NULL, '2026-04-17 22:46:24', '2026-04-17 22:46:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL COMMENT 'Ej: epayco_card, epayco_pse, epayco_cash, cod',
  `gateway` varchar(30) NOT NULL DEFAULT 'megapagos',
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(5) NOT NULL DEFAULT 'COP',
  `status` enum('pending','approved','rejected','expired','cancelled','refunded','partially_refunded','error') NOT NULL DEFAULT 'pending',
  `gateway_transaction_id` varchar(100) DEFAULT NULL COMMENT 'ID de transacci??n en ePayco',
  `gateway_reference` varchar(100) DEFAULT NULL COMMENT 'Referencia del gateway',
  `authorization_code` varchar(50) DEFAULT NULL,
  `franchise` varchar(30) DEFAULT NULL COMMENT 'Ej: Visa, Mastercard, PSE',
  `bank_name` varchar(100) DEFAULT NULL,
  `response_code` varchar(20) DEFAULT NULL,
  `response_message` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `refund_amount` decimal(12,2) DEFAULT 0.00,
  `refund_reason` text DEFAULT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `metadata` text DEFAULT NULL COMMENT 'Datos adicionales JSON',
  `raw_response` text DEFAULT NULL COMMENT 'Respuesta completa de MEGAPAGOS get-info',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL COMMENT 'C??digo ??nico del producto',
  `name` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Precio base sin descuento',
  `compare_price` decimal(12,2) DEFAULT NULL COMMENT 'Precio tachado / comparaci??n',
  `cost_price` decimal(12,2) DEFAULT NULL COMMENT 'Costo del producto (interno)',
  `tax_rate` decimal(5,2) DEFAULT NULL COMMENT 'NULL = usa tasa por defecto',
  `tax_included` tinyint(1) DEFAULT NULL COMMENT 'NULL = usa config global',
  `stock` int(11) NOT NULL DEFAULT 0,
  `low_stock_threshold` int(11) DEFAULT NULL,
  `weight` decimal(8,3) DEFAULT NULL COMMENT 'Peso en kg',
  `width` decimal(8,2) DEFAULT NULL COMMENT 'Ancho en cm',
  `height` decimal(8,2) DEFAULT NULL COMMENT 'Alto en cm',
  `length` decimal(8,2) DEFAULT NULL COMMENT 'Largo en cm',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_digital` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Producto digital (no requiere env??o)',
  `requires_shipping` tinyint(1) NOT NULL DEFAULT 1,
  `max_purchase_qty` int(11) DEFAULT NULL COMMENT 'M??ximo por compra',
  `min_purchase_qty` int(11) NOT NULL DEFAULT 1,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `sales_count` int(11) NOT NULL DEFAULT 0,
  `avg_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_reviews` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `tags` varchar(500) DEFAULT NULL COMMENT 'Tags separados por coma',
  `created_by` int(11) DEFAULT NULL COMMENT 'ID del admin que lo cre??',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `slug`, `description`, `short_description`, `category_id`, `brand_id`, `price`, `compare_price`, `cost_price`, `tax_rate`, `tax_included`, `stock`, `low_stock_threshold`, `weight`, `width`, `height`, `length`, `is_active`, `is_featured`, `is_digital`, `requires_shipping`, `max_purchase_qty`, `min_purchase_qty`, `views_count`, `sales_count`, `avg_rating`, `total_reviews`, `meta_title`, `meta_description`, `tags`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'EJ12345', 'Producto uno', 'producto-uno', 'Si vas a usar el micrÃ³fono en un escritorio fijo para gaming, streaming o podcast, el BOYA es la mejor compra: mÃ¡s specs tÃ©cnicos, patrÃ³n mÃ¡s enfocado, boom arm incluido, y menor precio. El DGM20W solo vale la diferencia si la libertad inalÃ¡mbrica es una prioridad real para vos', 'Prueba de descripcion de producto', 1, NULL, 23000.00, 29000.00, 16000.00, NULL, NULL, 20, 5, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, 'Prueba, Producto nuevo, Otra prueba', NULL, '2026-06-05 00:13:52', '2026-06-05 00:45:31'),
(2, 'CAM-001', 'Camiseta Poder Down â€” Amor Propio', 'camiseta-poder-down-amor-propio', 'Camiseta 100% algodÃ³n con diseÃ±o exclusivo \"Amor Propio\" por MarÃ­a Camila GonzÃ¡lez Torres.', 'Camiseta algodÃ³n diseÃ±o Amor Propio', 2, NULL, 45000.00, 55000.00, 22000.00, NULL, NULL, 30, 5, NULL, NULL, NULL, NULL, 1, 1, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(3, 'TZA-001', 'Taza Poder Down â€” SueÃ±os Sin LÃ­mites', 'taza-poder-down-suenos-sin-limites', 'Taza de cerÃ¡mica de 350ml con ilustraciÃ³n original de Cami.', 'Taza cerÃ¡mica 350ml', 5, NULL, 28000.00, 35000.00, 12000.00, NULL, NULL, 25, 5, NULL, NULL, NULL, NULL, 1, 1, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(4, 'LIB-001', 'Libreta Poder Down â€” Crea Sin Miedo', 'libreta-poder-down-crea-sin-miedo', 'Libreta de tapa dura, 80 hojas rayadas, con ilustraciÃ³n portada por MarÃ­a Camila GonzÃ¡lez Torres.', 'Libreta tapa dura 80 hojas', 4, NULL, 22000.00, NULL, 9000.00, NULL, NULL, 40, 10, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(5, 'STK-001', 'Pack Stickers Poder Down â€” 10 uds', 'pack-stickers-poder-down-10-uds', 'Set de 10 stickers adhesivos con frases y diseÃ±os inspiradores. TamaÃ±o 5x5 cm c/u.', 'Pack 10 stickers inspiradores', 4, NULL, 12000.00, 15000.00, 5000.00, NULL, NULL, 100, 20, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(6, 'CUA-001', 'Lienzo Poder Down â€” La Esperanza', 'lienzo-poder-down-la-esperanza', 'ImpresiÃ³n en lienzo de alta calidad sobre bastidor 30x40 cm. Obra \"La Esperanza\".', 'Lienzo 30x40 cm La Esperanza', 6, NULL, 65000.00, 80000.00, 30000.00, NULL, NULL, 10, 3, NULL, NULL, NULL, NULL, 1, 1, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(7, 'MCH-001', 'Mochila Poder Down â€” InclusiÃ³n', 'mochila-poder-down-inclusion', 'Mochila impermeable 25L con diseÃ±o bordado. Compartimento para laptop hasta 15.6\".', 'Mochila 25L impermeable', 9, NULL, 72000.00, 85000.00, 35000.00, NULL, NULL, 15, 4, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(8, 'BOC-001', 'Boceto Original â€” Retrato Familiar', 'boceto-original-retrato-familiar', 'Boceto original a mano por MarÃ­a Camila GonzÃ¡lez Torres. LÃ¡piz sobre papel. Incluye certificado.', 'Boceto original Retrato Familiar', 11, NULL, 95000.00, NULL, 15000.00, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(9, 'COJ-001', 'CojÃ­n Poder Down â€” Abrazo de Colores', 'coin-poder-down-abrazo-de-colores', 'CojÃ­n decorativo 45x45 cm, funda removible, diseÃ±o full color. Relleno hipoalergÃ©nico.', 'CojÃ­n 45x45 colorido', 5, NULL, 38000.00, 45000.00, 18000.00, NULL, NULL, 20, 5, NULL, NULL, NULL, NULL, 1, 0, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(10, 'TLL-001', 'Taller Online â€” Pintando con Cami', 'taller-online-pintando-con-cami', 'Acceso al taller virtual grabado de 2 horas. Cami comparte tÃ©cnicas de pintura y su historia.', 'Taller online 2h con Cami', 8, NULL, 35000.00, NULL, 5000.00, NULL, NULL, 999, 10, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02'),
(11, 'PIN-001', 'Pintura Original â€” El Poder de Creer', 'pintura-original-el-poder-de-creer', 'Obra original Ãºnica en acrÃ­lico sobre lienzo 50x70 cm. Firmada por Cami. Incluye certificado de autenticidad.', 'Obra original Ãºnica 50x70 cm', 7, NULL, 250000.00, NULL, 80000.00, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 0, 1, NULL, 1, 0, 0, 0.00, 0, NULL, NULL, NULL, NULL, '2026-06-05 18:11:47', '2026-06-05 18:14:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'Ej: Color, Talla, Material',
  `slug` varchar(120) NOT NULL,
  `type` enum('select','color','text') NOT NULL DEFAULT 'select',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `name`, `slug`, `type`, `sort_order`, `created_at`) VALUES
(1, 'Color', 'color', 'color', 0, '2026-04-17 22:46:24'),
(2, 'Talla', 'talla', 'select', 0, '2026-04-17 22:46:24'),
(3, 'Material', 'material', 'select', 0, '2026-04-17 22:46:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `color_hex` varchar(7) DEFAULT NULL COMMENT 'Solo para tipo color, ej: #FF0000',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `alt_text`, `sort_order`, `is_primary`, `created_at`) VALUES
(1, 1, 'img/fotos_productos/EJ12345_1780630837_0.png', 'pd_icono', 1, 0, '2026-06-05 03:40:37'),
(2, 1, 'img/fotos_productos/EJ12345_1780630837_1.png', 'poder_down_vertical-grande-removebg-preview', 0, 0, '2026-06-05 03:40:37'),
(3, 1, 'img/fotos_productos/EJ12345_1780630837_2.png', 'poder_down_vertical-grande', 2, 1, '2026-06-05 03:40:37'),
(4, 1, 'img/fotos_productos/EJ12345_1780630837_3.png', 'logo_poder_down-removebg-preview', 4, 0, '2026-06-05 03:40:37'),
(5, 1, 'img/fotos_productos/EJ12345_1780630837_4.png', 'logo_poder_down', 3, 0, '2026-06-05 03:40:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_relations`
--

CREATE TABLE `product_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `product_id` int(11) NOT NULL,
  `related_product_id` int(11) NOT NULL,
  `relation_type` enum('related','upsell','cross_sell') NOT NULL DEFAULT 'related',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT 'Pedido asociado a la rese??a',
  `rating` tinyint(1) NOT NULL COMMENT '1-5 estrellas',
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `pros` text DEFAULT NULL COMMENT 'Puntos a favor',
  `cons` text DEFAULT NULL COMMENT 'Puntos en contra',
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `admin_response` text DEFAULT NULL,
  `admin_response_at` datetime DEFAULT NULL,
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(80) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Nombre descriptivo de la variante',
  `price` decimal(12,2) DEFAULT NULL COMMENT 'NULL = usa precio del producto',
  `compare_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` decimal(8,3) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_variant_attributes`
--

CREATE TABLE `product_variant_attributes` (
  `id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `return_number` varchar(30) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reason` enum('defective','wrong_item','not_as_described','no_longer_needed','other') NOT NULL,
  `reason_detail` text DEFAULT NULL,
  `status` enum('requested','approved','rejected','received','refunded','closed') NOT NULL DEFAULT 'requested',
  `refund_amount` decimal(12,2) DEFAULT NULL,
  `refund_method` enum('original_payment','store_credit','bank_transfer') DEFAULT 'original_payment',
  `admin_notes` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `return_items`
--

CREATE TABLE `return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `return_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `condition_received` enum('new','used','damaged') DEFAULT NULL,
  `restock` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  `nombre` varchar(255) NOT NULL,
  `creado_por` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms_credentials`
--

CREATE TABLE `sms_credentials` (
  `id` int(11) NOT NULL,
  `apiKey` varchar(255) NOT NULL,
  `apiSecret` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sms_credentials`
--

INSERT INTO `sms_credentials` (`id`, `apiKey`, `apiSecret`) VALUES
(1, 'mz7Y5j47vK', 'a7fcgcxbme');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` varchar(160) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smtpconfig`
--

CREATE TABLE `smtpconfig` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `dependence` text NOT NULL,
  `Subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoriales`
--

CREATE TABLE `tutoriales` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `modulo` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` text NOT NULL,
  `rol` int(2) NOT NULL,
  `rol_informativo` int(11) NOT NULL,
  `extra_rol` int(2) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL,
  `fechaCreacionUser` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `genero` text NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nombre`, `rol`, `rol_informativo`, `extra_rol`, `foto`, `orden`, `fechaCreacionUser`, `email`, `genero`, `telefono`, `direccion`, `edad`) VALUES
(1, 22233344, '$2y$10$oHlCEOyRw3OJekppM4GHNuRJQWbzFckUaYZxH9izo/XSna/zqaoTq', 'Noble Six', 1, 0, 0, '22233344_24102025.png', 1, '24102025200135', 'juandidoc11@gmail.com', 'Hombre', '3508284544', 'Diagonal 57 # 47 a 28', 33),
(2, 1047996089, '$2y$10$QOCSN0UKZNh0XxmwTUhpMOMrodaIvPbeIaEm9XMftHhy9kCES/ngO', 'Jhon Darwin Acevedo', 12, 0, 0, 'JHON-D.png', 1, '2021-11-01 20:5', 'info@agenciaeaglesoftware.com', 'Masculino', '3015606006', 'Calle 98b#40-05', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_register`
--

CREATE TABLE `user_register` (
  `id` int(11) NOT NULL,
  `typeID` varchar(30) NOT NULL,
  `number_id` bigint(50) NOT NULL,
  `number_id_very` varchar(15) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `second_name` varchar(25) NOT NULL,
  `first_last` varchar(25) NOT NULL,
  `second_last` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `expedition_date` date NOT NULL,
  `gender` mediumtext NOT NULL,
  `marital_status` mediumtext NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_very` varchar(255) NOT NULL,
  `first_phone` varchar(15) NOT NULL,
  `second_phone` varchar(15) NOT NULL,
  `password` varchar(25) NOT NULL,
  `emergency_contact_name` varchar(150) NOT NULL,
  `emergency_contact_number` varchar(15) NOT NULL,
  `nationality` mediumtext NOT NULL,
  `department` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `people_charge` int(2) NOT NULL,
  `vulnerable_population` varchar(2) NOT NULL,
  `vulnerable_type` varchar(50) NOT NULL,
  `ethnic_group` varchar(255) NOT NULL,
  `stratum` int(1) NOT NULL,
  `residence_area` mediumtext NOT NULL,
  `training_level` varchar(50) NOT NULL,
  `occupation` mediumtext NOT NULL,
  `time_obligations` varchar(50) NOT NULL,
  `motivations_belong_program` varchar(255) NOT NULL,
  `current_situation` varchar(255) NOT NULL,
  `impediment_complete_course` varchar(70) NOT NULL,
  `availability` mediumtext NOT NULL,
  `mode` varchar(50) NOT NULL,
  `headquarters` varchar(255) NOT NULL,
  `program` varchar(50) NOT NULL,
  `schedules` varchar(255) NOT NULL,
  `schedules_alternative` varchar(255) NOT NULL,
  `prior_knowledge` varchar(2) NOT NULL,
  `level` varchar(50) NOT NULL,
  `languages` varchar(25) NOT NULL,
  `languages_level` varchar(25) NOT NULL,
  `medical_condition` varchar(2) NOT NULL,
  `disability` varchar(2) NOT NULL,
  `type_disability` varchar(120) NOT NULL,
  `pregnancy` varchar(2) NOT NULL,
  `country_person` varchar(2) NOT NULL,
  `technologies` varchar(25) NOT NULL,
  `internet` varchar(2) NOT NULL,
  `knowledge_program` varchar(255) NOT NULL,
  `accept_requirements` varchar(2) NOT NULL,
  `accepts_tech_talent` varchar(2) NOT NULL,
  `accept_data_policies` varchar(2) NOT NULL,
  `file_front_id` varchar(255) NOT NULL,
  `file_back_id` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `statusAdmin` int(1) NOT NULL,
  `lote` int(1) NOT NULL,
  `directed_base` int(1) NOT NULL,
  `idCourse` int(5) NOT NULL,
  `contactMedium` mediumtext NOT NULL,
  `institution` varchar(255) NOT NULL,
  `creationDate` datetime NOT NULL,
  `dayUpdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Ãndices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `email_history`
--
ALTER TABLE `email_history`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `email_recipients`
--
ALTER TABLE `email_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_id` (`email_id`);

--
-- Indices de la tabla `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_correos`
--
ALTER TABLE `historial_correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sms_credentials`
--
ALTER TABLE `sms_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `smtpconfig`
--
ALTER TABLE `smtpconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutoriales`
--
ALTER TABLE `tutoriales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `user_register`
--
ALTER TABLE `user_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_register_lote_number_headquarters` (`lote`,`number_id`,`headquarters`),
  ADD KEY `idx_user_register_institution` (`institution`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `email_history`
--
ALTER TABLE `email_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `email_recipients`
--
ALTER TABLE `email_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_correos`
--
ALTER TABLE `historial_correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1101;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sms_credentials`
--
ALTER TABLE `sms_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `smtpconfig`
--
ALTER TABLE `smtpconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tutoriales`
--
ALTER TABLE `tutoriales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `user_register`
--
ALTER TABLE `user_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `email_recipients`
--
ALTER TABLE `email_recipients`
  ADD CONSTRAINT `email_recipients_ibfk_1` FOREIGN KEY (`email_id`) REFERENCES `email_history` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

