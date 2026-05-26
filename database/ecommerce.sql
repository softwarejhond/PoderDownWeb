-- ============================================================
-- BASE DE DATOS: ecommerce
-- Motor: MySQL 5.7+ / MariaDB 10.4+
-- Compatible con MAMP y XAMPP
-- Codificación: UTF-8
-- ============================================================

CREATE DATABASE IF NOT EXISTS `ecommerce`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `ecommerce`;

-- ------------------------------------------------------------
-- TABLA: categorias
-- Agrupa los productos por tipo
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre`      VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `activo`      TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- TABLA: productos
-- Inventario principal del ecommerce
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `productos` (
  `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `categoria_id` INT UNSIGNED NOT NULL,
  `nombre`       VARCHAR(200) NOT NULL,
  `descripcion`  TEXT,
  `precio`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `stock`        INT NOT NULL DEFAULT 0,
  `imagen`       VARCHAR(255) DEFAULT 'default.jpg',
  `activo`       TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- TABLA: clientes
-- Usuarios registrados en el ecommerce
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clientes` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre`     VARCHAR(150) NOT NULL,
  `email`      VARCHAR(150) NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `telefono`   VARCHAR(20),
  `activo`     TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- DATOS DE PRUEBA: categorias
-- ------------------------------------------------------------
INSERT INTO `categorias` (`nombre`, `descripcion`) VALUES
  ('Electrónica',    'Dispositivos y gadgets tecnológicos'),
  ('Ropa',           'Moda y accesorios de vestir'),
  ('Hogar',          'Artículos para el hogar y decoración'),
  ('Deportes',       'Equipos y ropa deportiva'),
  ('Libros',         'Literatura, ciencia y entretenimiento');

-- ------------------------------------------------------------
-- DATOS DE PRUEBA: productos
-- ------------------------------------------------------------
INSERT INTO `productos` (`categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
  (1, 'Smartphone Pro X',       'Pantalla AMOLED 6.7", 256GB, cámara 108MP',    899.99,  45, 'smartphone.jpg'),
  (1, 'Laptop UltraSlim 14',    'Intel Core i7, 16GB RAM, SSD 512GB',          1299.99,  20, 'laptop.jpg'),
  (1, 'Auriculares Noise Pro',  'Cancelación activa de ruido, 30h batería',      199.99,  80, 'auriculares.jpg'),
  (2, 'Camiseta Deportiva Dry', 'Tela transpirable, disponible en 4 tallas',      29.99, 200, 'camiseta.jpg'),
  (2, 'Chaqueta Urban Style',   'Impermeable, ligera, colores variados',           89.99,  60, 'chaqueta.jpg'),
  (3, 'Lámpara LED Minimalista','Luz regulable, brazo articulado, USB-C',          49.99, 110, 'lampara.jpg'),
  (3, 'Silla Ergonómica Pro',   'Soporte lumbar, altura ajustable, ruedas',       349.99,  25, 'silla.jpg'),
  (4, 'Bicicleta MTB Xcross',   'Aluminio 29", 21 velocidades, frenos disco',     599.99,  15, 'bicicleta.jpg'),
  (4, 'Mancuernas Ajustables',  'Par 5-25kg, agarre antideslizante',              129.99,  40, 'mancuernas.jpg'),
  (5, 'Clean Code - R.Martin',  'Edición en español, tapa blanda',                 34.99, 500, 'libro1.jpg'),
  (5, 'Diseño UX/UI Moderno',   'Guía práctica con ejemplos reales',               27.99, 300, 'libro2.jpg'),
  (1, 'Tablet DrawPad 12',      'Pantalla 12", lápiz óptico incluido, WiFi',      449.99,  30, 'tablet.jpg');

-- ============================================================
-- TABLA: pedidos (órdenes sin registro de usuario)
-- ============================================================
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `codigo`          VARCHAR(20) NOT NULL UNIQUE,
  `nombre`          VARCHAR(150) NOT NULL,
  `email`           VARCHAR(150) NOT NULL,
  `telefono`        VARCHAR(25) NOT NULL,
  `ciudad`          VARCHAR(100) NOT NULL,
  `direccion`       TEXT NOT NULL,
  `notas`           TEXT,
  `estado`          ENUM('pendiente','confirmado','preparando','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `total`           DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `created_at`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLA: pedido_items (líneas del pedido)
-- ============================================================
CREATE TABLE IF NOT EXISTS `pedido_items` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `pedido_id`   INT UNSIGNED NOT NULL,
  `producto_id` INT UNSIGNED NOT NULL,
  `nombre`      VARCHAR(200) NOT NULL,
  `precio`      DECIMAL(10,2) NOT NULL,
  `cantidad`    INT NOT NULL DEFAULT 1,
  `subtotal`    DECIMAL(12,2) NOT NULL,
  FOREIGN KEY (`pedido_id`)   REFERENCES `pedidos`(`id`)   ON DELETE CASCADE,
  FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
