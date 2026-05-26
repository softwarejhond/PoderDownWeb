<?php
// ============================================================
// api/productos.php
// ENDPOINT: /api/productos.php   Método: GET
//
// Funciona en DOS modos según config/config.php:
//
//   MOCK_MODE = true  → Datos de prueba estáticos (sin BD)
//                       Funciona sin MAMP, sin MySQL
//
//   MOCK_MODE = false → Datos reales desde MySQL
//                       Requiere MAMP corriendo + SQL importado
//
// Parámetros GET soportados:
//   ?stats=1              → Resumen del inventario
//   ?id=N                 → Producto por ID
//   ?busqueda=texto       → Búsqueda por nombre/descripción
//   ?categoria=Electrónica→ Filtrar por nombre de categoría
//   ?limite=8&offset=0    → Paginación
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/ApiHelper.php';

// Cabeceras CORS — permite que el JS del frontend consuma la API
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

ApiHelper::validarMetodo('GET');

// ============================================================
// MODO MOCK: datos de prueba estáticos (sin base de datos)
// ============================================================
if (MOCK_MODE) {

    require_once __DIR__ . '/mock_data.php';

    try {
        // ── Caso 1: ?stats=1 ─────────────────────────────────
        if (isset($_GET['stats'])) {
            ApiHelper::exito([
                'resumen'       => getMockStats(),
                'por_categoria' => getMockPorCategoria(),
            ], 'Estadísticas del inventario (modo prueba)');
        }

        // ── Caso 2: ?id=N ────────────────────────────────────
        elseif (!empty($_GET['id'])) {
            $id       = (int) $_GET['id'];
            $todos    = getMockProductos();
            $producto = current(array_filter($todos, fn($p) => $p['id'] === $id));

            if (!$producto) {
                ApiHelper::error("Producto #{$id} no encontrado.", 404);
            }
            ApiHelper::exito([$producto], 'Producto encontrado');
        }

        // ── Caso 3: lista con filtros ─────────────────────────
        else {
            $todos     = getMockProductos();
            $busqueda  = strtolower(trim($_GET['busqueda']  ?? ''));
            $categoria = strtolower(trim($_GET['categoria'] ?? ''));
            $limite    = !empty($_GET['limite']) ? (int) $_GET['limite'] : null;
            $offset    = !empty($_GET['offset']) ? (int) $_GET['offset'] : 0;

            // Filtro por texto
            if ($busqueda) {
                $todos = array_filter($todos, fn($p) =>
                    str_contains(strtolower($p['nombre']), $busqueda) ||
                    str_contains(strtolower($p['descripcion']), $busqueda)
                );
            }

            // Filtro por categoría
            if ($categoria) {
                $todos = array_filter($todos, fn($p) =>
                    strtolower($p['categoria']) === $categoria
                );
            }

            $todos = array_values($todos);
            $total = count($todos);

            // Paginación
            if ($limite !== null) {
                $todos = array_slice($todos, $offset, $limite);
            }

            ApiHelper::responder([
                'exito'    => true,
                'mensaje'  => 'Productos de prueba (MOCK_MODE activo)',
                'total'    => $total,
                'cantidad' => count($todos),
                'datos'    => $todos,
            ]);
        }

    } catch (Exception $e) {
        ApiHelper::error('Error en datos de prueba: ' . $e->getMessage(), 500);
    }

    exit; // Termina aquí en modo mock
}

// ============================================================
// MODO REAL: consulta a MySQL via PDO
// Solo se ejecuta cuando MOCK_MODE = false
// ============================================================
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/ProductoModel.php';

$modelo = new ProductoModel();

try {
    if (isset($_GET['stats'])) {
        ApiHelper::exito([
            'resumen'       => $modelo->resumenInventario(),
            'por_categoria' => $modelo->obtenerPorCategoria(),
        ], 'Estadísticas de inventario');
    }

    elseif (!empty($_GET['id'])) {
        $id      = (int) $_GET['id'];
        $producto = $modelo->obtenerPorId($id);
        if (!$producto) ApiHelper::error("Producto #{$id} no encontrado.", 404);
        ApiHelper::exito([$producto], 'Producto encontrado');
    }

    else {
        $filtros = [
            'busqueda'     => trim($_GET['busqueda']     ?? ''),
            'categoria_id' => (int)($_GET['categoria_id'] ?? 0) ?: null,
            'orden'        => $_GET['orden']              ?? 'p.created_at DESC',
            'limite'       => !empty($_GET['limite']) ? (int)$_GET['limite'] : null,
            'offset'       => !empty($_GET['offset']) ? (int)$_GET['offset'] : 0,
        ];

        $productos = $modelo->obtenerTodos($filtros);
        $total     = $modelo->contarTodos($filtros);

        ApiHelper::responder([
            'exito'    => true,
            'mensaje'  => 'Productos obtenidos correctamente',
            'total'    => $total,
            'cantidad' => count($productos),
            'datos'    => $productos,
        ]);
    }

} catch (Exception $e) {
    $msg = DEBUG_MODE ? $e->getMessage() : 'Error al procesar la solicitud.';
    ApiHelper::error($msg, 500);
}
