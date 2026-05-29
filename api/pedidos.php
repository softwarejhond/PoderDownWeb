<?php
// ============================================================
// api/pedidos.php — Crear pedidos (POST) y listar (GET)
// QA: validación completa, precio verificado contra BD,
//     sanitización XSS, rate limiting, security headers
// ============================================================
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/ApiHelper.php';

ApiHelper::setHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/PedidoModel.php';
require_once __DIR__ . '/../app/models/ProductoModel.php';

$modelo   = new PedidoModel();
$modProd  = new ProductoModel();
$method   = $_SERVER['REQUEST_METHOD'];

try {
    // ── GET ──────────────────────────────────────────────────
    if ($method === 'GET') {
        if (!empty($_GET['id'])) {
            $pedido = $modelo->obtenerPorId((int) $_GET['id']);
            if (!$pedido) ApiHelper::error('Pedido no encontrado.', 404);
            $pedido['items'] = $modelo->obtenerItems((int) $_GET['id']);
            ApiHelper::exito([$pedido], 'Pedido encontrado');
        }
        if (isset($_GET['resumen'])) {
            ApiHelper::exito([$modelo->resumen()], 'Resumen de pedidos');
        }
        $filtros = [
            'estado'   => ApiHelper::sanitizeString($_GET['estado']   ?? '', 30),
            'busqueda' => ApiHelper::sanitizeString($_GET['busqueda'] ?? '', 100),
            'limite'   => min(100, max(1, (int)($_GET['limite'] ?? 50))),
            'offset'   => max(0, (int)($_GET['offset'] ?? 0)),
        ];
        ApiHelper::responder([
            'exito'    => true,
            'mensaje'  => 'Pedidos obtenidos',
            'total'    => $modelo->contar($filtros),
            'cantidad' => count($modelo->obtenerTodos($filtros)),
            'datos'    => $modelo->obtenerTodos($filtros),
        ]);
    }

    // ── POST: crear pedido ───────────────────────────────────
    elseif ($method === 'POST') {

        // Rate limiting: máx 5 pedidos por IP por hora
        ApiHelper::checkRateLimit('order', RATE_LIMIT_ORDERS, RATE_LIMIT_WINDOW);

        $raw = file_get_contents('php://input');
        $body = json_decode($raw, true);
        if (!is_array($body)) ApiHelper::error('JSON inválido.', 400);

        // ── Validar campos requeridos ────────────────────────
        $requeridos = ['nombre','email','telefono','ciudad','direccion','items'];
        foreach ($requeridos as $campo) {
            if (empty($body[$campo])) ApiHelper::error("El campo '{$campo}' es requerido.", 422);
        }

        // ── Sanitizar datos personales ───────────────────────
        $nombre    = ApiHelper::sanitizeString($body['nombre'],    120);
        $email     = ApiHelper::sanitizeEmail ($body['email']);
        $telefono  = ApiHelper::sanitizeString($body['telefono'],   30);
        $ciudad    = ApiHelper::sanitizeString($body['ciudad'],    100);
        $direccion = ApiHelper::sanitizeString($body['direccion'], 200);
        $notas     = ApiHelper::sanitizeString($body['notas'] ?? '', 500);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ApiHelper::error('Email inválido.', 422);
        }
        if (strlen($nombre) < 3) ApiHelper::error('Nombre demasiado corto.', 422);

        // ── Validar items ────────────────────────────────────
        if (!is_array($body['items']) || count($body['items']) === 0) {
            ApiHelper::error('El carrito está vacío.', 422);
        }
        if (count($body['items']) > 50) {
            ApiHelper::error('Carrito excede el límite de 50 productos.', 422);
        }

        // ── CRÍTICO: verificar precio contra base de datos ───
        // El cliente NO puede dictar el precio — se lee siempre de BD
        $itemsValidados = [];
        foreach ($body['items'] as $item) {
            $itemId  = (int)($item['id'] ?? 0);
            $itemQty = (int)($item['cantidad'] ?? 0);

            if ($itemId <= 0 || $itemQty <= 0) {
                ApiHelper::error('Item de carrito inválido.', 422);
            }
            if ($itemQty > 999) {
                ApiHelper::error('Cantidad excede el máximo permitido.', 422);
            }

            // Leer precio REAL desde BD — ignora el precio del cliente
            $producto = $modProd->obtenerPorId($itemId);
            if (!$producto) {
                ApiHelper::error("Producto #{$itemId} no encontrado.", 404);
            }
            if ((int)$producto['activo'] !== 1) {
                ApiHelper::error("El producto '{$producto['nombre']}' no está disponible.", 422);
            }
            if ((int)$producto['stock'] < $itemQty) {
                ApiHelper::error("Stock insuficiente para '{$producto['nombre']}'.", 422);
            }

            $itemsValidados[] = [
                'id'       => $itemId,
                'nombre'   => $producto['nombre'],   // nombre desde BD
                'precio'   => (float)$producto['precio'], // precio desde BD ← CLAVE
                'cantidad' => $itemQty,
            ];
        }

        $pedidoId = $modelo->crear([
            'nombre'    => $nombre,
            'email'     => $email,
            'telefono'  => $telefono,
            'ciudad'    => $ciudad,
            'direccion' => $direccion,
            'notas'     => $notas,
        ], $itemsValidados);

        $pedido           = $modelo->obtenerPorId($pedidoId);
        $pedido['items']  = $modelo->obtenerItems($pedidoId);

        ApiHelper::exito([$pedido], 'Pedido creado correctamente.', 201);
    }

    else {
        ApiHelper::error('Método no permitido.', 405);
    }

} catch (Exception $e) {
    $msg = (defined('DEBUG_MODE') && DEBUG_MODE) ? $e->getMessage() : 'Error al procesar el pedido.';
    ApiHelper::error($msg, 500);
}