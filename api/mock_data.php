<?php
// ============================================================
// api/mock_data.php
// DATOS DE PRUEBA ESTÁTICOS
// Se usa cuando MOCK_MODE = true en config.php
// No requiere base de datos ni MAMP corriendo
//
// Cuando tengas la BD lista:
//   1. Importa database/ecommerce.sql en phpMyAdmin
//   2. Cambia MOCK_MODE a false en config/config.php
//   3. ¡Listo! La API pasa a usar MySQL automáticamente
// ============================================================

// Lista de productos de prueba (simula lo que devolvería MySQL)
function getMockProductos(): array
{
    return [
        [
            'id'          => 1,
            'nombre'      => 'Smartphone Pro X',
            'descripcion' => 'Pantalla AMOLED 6.7", 256GB, cámara 108MP, batería 5000mAh',
            'precio'      => '899.99',
            'stock'       => 45,
            'imagen'      => 'smartphone.jpg',
            'activo'      => 1,
            'categoria'   => 'Electrónica',
            'created_at'  => '2025-01-10 09:00:00',
        ],
        [
            'id'          => 2,
            'nombre'      => 'Laptop UltraSlim 14',
            'descripcion' => 'Intel Core i7, 16GB RAM, SSD 512GB, pantalla IPS',
            'precio'      => '1299.99',
            'stock'       => 20,
            'imagen'      => 'laptop.jpg',
            'activo'      => 1,
            'categoria'   => 'Electrónica',
            'created_at'  => '2025-01-11 10:00:00',
        ],
        [
            'id'          => 3,
            'nombre'      => 'Auriculares Noise Pro',
            'descripcion' => 'Cancelación activa de ruido, 30h batería, conexión Bluetooth 5.2',
            'precio'      => '199.99',
            'stock'       => 80,
            'imagen'      => 'auriculares.jpg',
            'activo'      => 1,
            'categoria'   => 'Electrónica',
            'created_at'  => '2025-01-12 11:00:00',
        ],
        [
            'id'          => 4,
            'nombre'      => 'Camiseta Deportiva Dry',
            'descripcion' => 'Tela transpirable DryFit, disponible en tallas S, M, L, XL',
            'precio'      => '29.99',
            'stock'       => 200,
            'imagen'      => 'camiseta.jpg',
            'activo'      => 1,
            'categoria'   => 'Ropa',
            'created_at'  => '2025-01-13 09:30:00',
        ],
        [
            'id'          => 5,
            'nombre'      => 'Chaqueta Urban Style',
            'descripcion' => 'Impermeable, ligera, cierre YKK, colores variados',
            'precio'      => '89.99',
            'stock'       => 60,
            'imagen'      => 'chaqueta.jpg',
            'activo'      => 1,
            'categoria'   => 'Ropa',
            'created_at'  => '2025-01-14 10:00:00',
        ],
        [
            'id'          => 6,
            'nombre'      => 'Lámpara LED Minimalista',
            'descripcion' => 'Luz regulable 3 tonos, brazo articulado, carga USB-C incluida',
            'precio'      => '49.99',
            'stock'       => 110,
            'imagen'      => 'lampara.jpg',
            'activo'      => 1,
            'categoria'   => 'Hogar',
            'created_at'  => '2025-01-15 08:00:00',
        ],
        [
            'id'          => 7,
            'nombre'      => 'Silla Ergonómica Pro',
            'descripcion' => 'Soporte lumbar ajustable, altura regulable, ruedas antirayaduras',
            'precio'      => '349.99',
            'stock'       => 25,
            'imagen'      => 'silla.jpg',
            'activo'      => 1,
            'categoria'   => 'Hogar',
            'created_at'  => '2025-01-16 09:00:00',
        ],
        [
            'id'          => 8,
            'nombre'      => 'Bicicleta MTB Xcross',
            'descripcion' => 'Marco aluminio 29", 21 velocidades Shimano, frenos de disco hidráulicos',
            'precio'      => '599.99',
            'stock'       => 15,
            'imagen'      => 'bicicleta.jpg',
            'activo'      => 1,
            'categoria'   => 'Deportes',
            'created_at'  => '2025-01-17 10:00:00',
        ],
        [
            'id'          => 9,
            'nombre'      => 'Mancuernas Ajustables',
            'descripcion' => 'Par ajustable 5-25kg, agarre antideslizante, sistema de clic rápido',
            'precio'      => '129.99',
            'stock'       => 40,
            'imagen'      => 'mancuernas.jpg',
            'activo'      => 1,
            'categoria'   => 'Deportes',
            'created_at'  => '2025-01-18 11:00:00',
        ],
        [
            'id'          => 10,
            'nombre'      => 'Clean Code — R. Martin',
            'descripcion' => 'El libro esencial de programación limpia. Edición en español, tapa blanda',
            'precio'      => '34.99',
            'stock'       => 500,
            'imagen'      => 'libro1.jpg',
            'activo'      => 1,
            'categoria'   => 'Libros',
            'created_at'  => '2025-01-19 09:00:00',
        ],
        [
            'id'          => 11,
            'nombre'      => 'Diseño UX/UI Moderno',
            'descripcion' => 'Guía práctica con ejemplos reales, casos de estudio y ejercicios',
            'precio'      => '27.99',
            'stock'       => 300,
            'imagen'      => 'libro2.jpg',
            'activo'      => 1,
            'categoria'   => 'Libros',
            'created_at'  => '2025-01-20 10:00:00',
        ],
        [
            'id'          => 12,
            'nombre'      => 'Tablet DrawPad 12',
            'descripcion' => 'Pantalla 12" 2K, lápiz óptico 4096 niveles de presión, WiFi 6',
            'precio'      => '449.99',
            'stock'       => 0,   // Agotado — para probar el badge
            'imagen'      => 'tablet.jpg',
            'activo'      => 1,
            'categoria'   => 'Electrónica',
            'created_at'  => '2025-01-21 11:00:00',
        ],
        [
            'id'          => 13,
            'nombre'      => 'Colchoneta de Yoga Premium',
            'descripcion' => 'Antideslizante, 6mm grosor, lavable, incluye correa de transporte',
            'precio'      => '44.99',
            'stock'       => 3,   // Stock bajo — para probar el badge amarillo
            'imagen'      => 'yoga.jpg',
            'activo'      => 1,
            'categoria'   => 'Deportes',
            'created_at'  => '2025-01-22 09:00:00',
        ],
        [
            'id'          => 14,
            'nombre'      => 'Planta Artificial Decorativa',
            'descripcion' => 'Cactus XL 45cm, maceta cerámica incluida, sin mantenimiento',
            'precio'      => '19.99',
            'stock'       => 150,
            'imagen'      => 'planta.jpg',
            'activo'      => 1,
            'categoria'   => 'Hogar',
            'created_at'  => '2025-01-23 10:00:00',
        ],
        [
            'id'          => 15,
            'nombre'      => 'Vestido Floral Verano',
            'descripcion' => 'Tela ligera 100% algodón, estampado floral, tallas XS a XL',
            'precio'      => '54.99',
            'stock'       => 75,
            'imagen'      => 'vestido.jpg',
            'activo'      => 1,
            'categoria'   => 'Ropa',
            'created_at'  => '2025-01-24 11:00:00',
        ],
    ];
}

// ------------------------------------------------------------
// Estadísticas calculadas desde los datos mock
// Simula lo que devuelve resumenInventario() del modelo
// ------------------------------------------------------------
function getMockStats(): array
{
    $productos = getMockProductos();

    $totalProductos   = count($productos);
    $totalStock       = array_sum(array_column($productos, 'stock'));
    $valorInventario  = array_sum(array_map(fn($p) => $p['precio'] * $p['stock'], $productos));
    $sinStock         = count(array_filter($productos, fn($p) => $p['stock'] === 0));
    $stockBajo        = count(array_filter($productos, fn($p) => $p['stock'] > 0 && $p['stock'] <= 5));

    return [
        'total_productos'  => $totalProductos,
        'total_stock'      => $totalStock,
        'valor_inventario' => number_format($valorInventario, 2, '.', ''),
        'sin_stock'        => $sinStock,
        'stock_bajo'       => $stockBajo,
    ];
}

// ------------------------------------------------------------
// Agrupación por categoría
// Simula lo que devuelve obtenerPorCategoria() del modelo
// ------------------------------------------------------------
function getMockPorCategoria(): array
{
    $productos  = getMockProductos();
    $categorias = [];

    foreach ($productos as $p) {
        $cat = $p['categoria'];
        if (!isset($categorias[$cat])) {
            $categorias[$cat] = ['categoria' => $cat, 'cantidad' => 0, 'stock_total' => 0];
        }
        $categorias[$cat]['cantidad']++;
        $categorias[$cat]['stock_total'] += $p['stock'];
    }

    return array_values($categorias);
}
