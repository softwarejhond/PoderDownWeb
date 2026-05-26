<?php
// ============================================================
// api/pedidos_crud.php
// ENDPOINT: cambiar estado de un pedido (POST)
// ============================================================
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/ApiHelper.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

ApiHelper::validarMetodo('POST');

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/PedidoModel.php';

$action = trim($_POST['action'] ?? '');
$modelo = new PedidoModel();

try {
    switch ($action) {
        case 'estado':
            $id     = (int) ($_POST['id']     ?? 0);
            $estado = trim($_POST['estado']   ?? '');
            if (!$id || !$estado) ApiHelper::error('ID y estado requeridos.', 400);
            $ok = $modelo->cambiarEstado($id, $estado);
            if (!$ok) ApiHelper::error('Estado inválido o pedido no encontrado.', 404);
            ApiHelper::exito(['estado' => $estado], 'Estado actualizado.');
            break;

        default:
            ApiHelper::error("Acción '{$action}' no reconocida.", 400);
    }
} catch (Exception $e) {
    $msg = (defined('DEBUG_MODE') && DEBUG_MODE) ? $e->getMessage() : 'Error interno.';
    ApiHelper::error($msg, 500);
}
