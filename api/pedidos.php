<?php
// ============================================================
// api/pedidos.php
// ENDPOINT: crear pedidos (POST) y listar/detalle (GET)
// Sin autenticación de cliente — compra libre
// ============================================================
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/ApiHelper.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/PedidoModel.php';

$modelo = new PedidoModel();
$method = $_SERVER['REQUEST_METHOD'];

try {
    // ── GET: listar o detalle ────────────────────────────────
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
            'estado'   => $_GET['estado']   ?? '',
            'busqueda' => $_GET['busqueda'] ?? '',
            'limite'   => !empty($_GET['limite']) ? (int)$_GET['limite'] : 50,
            'offset'   => !empty($_GET['offset']) ? (int)$_GET['offset'] : 0,
        ];
        $pedidos = $modelo->obtenerTodos($filtros);
        $total   = $modelo->contar($filtros);

        ApiHelper::responder([
            'exito'    => true,
            'mensaje'  => 'Pedidos obtenidos',
            'total'    => $total,
            'cantidad' => count($pedidos),
            'datos'    => $pedidos,
        ]);
    }

    // ── POST: crear pedido ───────────────────────────────────
    elseif ($method === 'POST') {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) ApiHelper::error('JSON inválido.', 400);

        $requeridos = ['nombre','email','telefono','ciudad','direccion','items'];
        foreach ($requeridos as $campo) {
            if (empty($body[$campo])) ApiHelper::error("El campo '{$campo}' es requerido.", 422);
        }
        if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
            ApiHelper::error('Email inválido.', 422);
        }
        if (!is_array($body['items']) || count($body['items']) === 0) {
            ApiHelper::error('El carrito está vacío.', 422);
        }

        // Validar que los items tengan los campos mínimos
        foreach ($body['items'] as $item) {
            if (empty($item['id']) || empty($item['nombre']) || !isset($item['precio']) || empty($item['cantidad'])) {
                ApiHelper::error('Item de carrito inválido.', 422);
            }
        }

        $pedidoId = $modelo->crear([
            'nombre'    => $body['nombre'],
            'email'     => $body['email'],
            'telefono'  => $body['telefono'],
            'ciudad'    => $body['ciudad'],
            'direccion' => $body['direccion'],
            'notas'     => $body['notas'] ?? '',
        ], $body['items']);

        $pedido = $modelo->obtenerPorId($pedidoId);
        $pedido['items'] = $modelo->obtenerItems($pedidoId);

        ApiHelper::exito([$pedido], 'Pedido creado correctamente.', 201);
    }

    else {
        ApiHelper::error('Método no permitido.', 405);
    }

} catch (Exception $e) {
    $msg = (defined('DEBUG_MODE') && DEBUG_MODE) ? $e->getMessage() : 'Error al procesar el pedido.';
    ApiHelper::error($msg, 500);
}
