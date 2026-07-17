<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

define('LOG_DIR', __DIR__ . '/logs');
define('LOG_FILE', LOG_DIR . '/pagos_' . date('Y-m-d') . '.log');

function log_pago($mensaje, $data = null) {
    if (!is_dir(LOG_DIR)) { mkdir(LOG_DIR, 0755, true); }
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $mensaje;
    if ($data !== null) {
        $line .= ' | ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    $line .= PHP_EOL;
    file_put_contents(LOG_FILE, $line, FILE_APPEND | LOCK_EX);
}

log_pago('=== NUEVA PETICION ===');
log_pago('REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD']);
log_pago('INPUT RAW', file_get_contents('php://input'));

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    log_pago('ERROR: Metodo no permitido - ' . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode(['exito' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
log_pago('INPUT PARSED', $input);

$docTypeMap = [
    'CedulaDeCiudadania' => 'CC',
    'CedulaDeExtranjeria' => 'CE',
    'TarjetaDeIdentidad' => 'TI',
    'Nit' => 'NIT',
    'Pasaporte' => 'PP',
    'PEP' => 'PEP',
];
$tipoDocRaw = trim($input['tipo_documento'] ?? 'CedulaDeCiudadania');
$tipoDoc = $docTypeMap[$tipoDocRaw] ?? substr($tipoDocRaw, 0, 20);

if (!$input || empty($input['nombre']) || empty($input['email']) || empty($input['telefono'])) {
    log_pago('ERROR: Datos incompletos');
    http_response_code(400);
    echo json_encode(['exito' => false, 'mensaje' => 'Datos incompletos. Nombre, email y teléfono son obligatorios.']);
    exit;
}

$data = [
    'is_cart'         => !empty($input['is_cart']),
    'items'           => $input['items'] ?? [],
    'producto_id'     => (int) ($input['producto_id'] ?? 0),
    'variant_id'      => (int) ($input['variant_id'] ?? 0),
    'nombre'          => trim($input['nombre']),
    'email'           => trim($input['email']),
    'telefono'        => trim($input['telefono']),
    'ciudad'          => trim($input['ciudad'] ?? ''),
    'direccion'       => trim($input['direccion'] ?? ''),
    'departamento_nombre' => trim($input['departamento_nombre'] ?? ''),
    'municipio_nombre'    => trim($input['municipio_nombre'] ?? ''),
    'codigo_postal'   => trim($input['codigo_postal'] ?? ''),
    'notas'           => trim($input['notas'] ?? ''),
    'cantidad'        => (int) ($input['cantidad'] ?? 1),
    'total'           => (float) ($input['total'] ?? 0),
    'subtotal'        => (float) ($input['subtotal'] ?? $input['total'] ?? 0),
    'costo_envio'     => (float) ($input['costo_envio'] ?? 0),
    'metodo_pago'     => trim($input['metodo_pago'] ?? 'megapagos_pse'),
    'producto_nombre' => trim($input['producto_nombre'] ?? 'Producto Poder Down'),
    'producto_precio' => (float) ($input['producto_precio'] ?? 0),
    'documento'       => trim($input['documento'] ?? ''),
    'tipo_documento'  => $tipoDoc,
    'banco_codigo'    => trim($input['banco_codigo'] ?? ''),
    'banco_nombre'    => trim($input['banco_nombre'] ?? ''),
];

if (empty($data['documento'])) {
    log_pago('ERROR: Documento vacio');
    http_response_code(400);
    echo json_encode(['exito' => false, 'mensaje' => 'El número de documento es obligatorio.']);
    exit;
}

if (empty($data['banco_codigo'])) {
    log_pago('ERROR: Banco vacio');
    http_response_code(400);
    echo json_encode(['exito' => false, 'mensaje' => 'Debe seleccionar un banco.']);
    exit;
}

log_pago('DB: Conectando...');
require_once __DIR__ . '/controller/conexion.php';
require_once __DIR__ . '/controller/megapagos.php';
log_pago('DB: Conectado OK');

mysqli_begin_transaction($conn);
log_pago('DB: Transaccion iniciada');

try {
    $orderNumber = 'PD-' . strtoupper(substr(uniqid(), -8));
    log_pago('ORDER: ' . $orderNumber);
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (order_number, customer_email, customer_name, customer_phone, customer_document_type, customer_document_number, shipping_department, shipping_city, shipping_address, shipping_address_detail, shipping_postal_code, subtotal, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, 'sssssssssssdd',
        $orderNumber,
        $data['email'],
        $data['nombre'],
        $data['telefono'],
        $data['tipo_documento'],
        $data['documento'],
        $data['departamento_nombre'],
        $data['municipio_nombre'],
        $data['direccion'],
        $data['notas'],
        $data['codigo_postal'],
        $data['subtotal'],
        $data['total']
    );
    mysqli_stmt_execute($stmt);
    $orderId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    log_pago('ORDER: Insertado ID=' . $orderId);

    if ($data['is_cart'] && !empty($data['items'])) {
        $descripcion = 'Pedido múltiple: ';
        $nombres = [];
        $primerItem = null;
        foreach ($data['items'] as $item) {
            $nombres[] = ($item['nombre'] ?? 'Producto') . ' x' . ($item['cantidad'] ?? 1);
            if (!$primerItem) $primerItem = $item;

            $stmtItem = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, variant_id, product_name, quantity, unit_price, subtotal, total, sku) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '')");
            $pid = (int)($item['producto_id'] ?? 0);
            $pnombre = $item['nombre'] ?? 'Producto';
            $pqty = (int)($item['cantidad'] ?? 1);
            $pprice = (float)($item['precio'] ?? 0);
            $vid = (int)($item['variant_id'] ?? 0);
            $lineTotal = $pprice * $pqty;
            mysqli_stmt_bind_param($stmtItem, 'iiisiddd', $orderId, $pid, $vid, $pnombre, $pqty, $pprice, $lineTotal, $lineTotal);
            mysqli_stmt_execute($stmtItem);
            mysqli_stmt_close($stmtItem);
        }
        $descripcion .= implode(', ', $nombres) . (!empty($data['notas']) ? ' - Notas: ' . $data['notas'] : '');
        log_pago('ITEMS: Insertados ' . count($data['items']) . ' items');
    } else {
        $descripcion = $data['producto_nombre'] . (!empty($data['notas']) ? ' - Notas: ' . $data['notas'] : '');
        $stmtItem = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, variant_id, product_name, quantity, unit_price, subtotal, total, sku) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '')");
        $lineTotal = $data['producto_precio'] * $data['cantidad'];
        mysqli_stmt_bind_param($stmtItem, 'iiisiddd',
            $orderId,
            $data['producto_id'],
            $data['variant_id'],
            $data['producto_nombre'],
            $data['cantidad'],
            $data['producto_precio'],
            $lineTotal,
            $lineTotal
        );
        mysqli_stmt_execute($stmtItem);
        mysqli_stmt_close($stmtItem);
        log_pago('ITEM: Insertado 1 item');
    }

    $stmtPay = mysqli_prepare($conn, "INSERT INTO payments (order_id, customer_id, payment_method, gateway, amount, currency, status) VALUES (?, NULL, ?, 'megapagos', ?, 'COP', 'pending')");
    $metodo = 'megapagos_pse';
    mysqli_stmt_bind_param($stmtPay, 'isd', $orderId, $metodo, $data['total']);
    mysqli_stmt_execute($stmtPay);
    $paymentId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtPay);
    log_pago('PAYMENT: Insertado ID=' . $paymentId);

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $protocol . '://' . $host . $scriptDir;
    log_pago('BASE_URL: ' . $baseUrl);

    $megapagos = new MegapagosClient($conn);
    log_pago('MEGAPAGOS: Cliente creado. Haciendo login...');

    $megapagos->login();
    log_pago('MEGAPAGOS: Login OK');

    $orderMegapagos = [
        'external_url'        => $baseUrl . '/callback?order=' . $orderId . '&payment=' . $paymentId,
        'product_name'        => $data['producto_nombre'],
        'product_description' => $descripcion,
        'unit_price'          => $data['producto_precio'],
        'tax_id'              => 21,
        'shipping_cost'       => $data['costo_envio'],
        'quantity'            => $data['cantidad'],
        'total_amount'        => $data['total'],
        'payer_name'          => $data['nombre'],
        'payer_email'         => $data['email'],
        'payer_address'       => $data['direccion'],
        'payer_phone'         => $data['telefono'],
        'bank_code'           => $data['banco_codigo'],
        'document_number'     => $data['documento'],
        'document_type'       => $data['tipo_documento'],
        'person_type'         => 'person',
    ];

    log_pago('MEGAPAGOS: Creando transaccion PSE', $orderMegapagos);

    $response = $megapagos->createPseTransaction($orderMegapagos);
    log_pago('MEGAPAGOS: Respuesta createPseTransaction', $response);

    $transactionId = $response['transactionId'] ?? null;
    $trazabilityCode = $response['trazabilityCode'] ?? null;
    $pseURL = $response['pseURL'] ?? null;

    if (!$pseURL) {
        log_pago('ERROR: No se obtuvo pseURL en la respuesta');
        throw new Exception('No se obtuvo URL de pago PSE de MEGAPAGOS.');
    }

    log_pago('PSE_URL: ' . $pseURL);

    $stmtUpd = mysqli_prepare($conn, "UPDATE payments SET gateway_transaction_id = ?, gateway_reference = ?, franchise = 'PSE', bank_name = ?, status = 'pending', metadata = ? WHERE id = ?");
    $metadata = json_encode([
        'trazabilityCode' => $trazabilityCode,
        'bank_code'       => $data['banco_codigo'],
        'document_type'   => $data['tipo_documento'],
        'document_number' => $data['documento'],
    ]);
    mysqli_stmt_bind_param($stmtUpd, 'ssssi', $transactionId, $trazabilityCode, $data['banco_nombre'], $metadata, $paymentId);
    mysqli_stmt_execute($stmtUpd);
    mysqli_stmt_close($stmtUpd);

    mysqli_commit($conn);
    log_pago('DB: Commit OK. TODO EXITOSO');

    ob_end_clean();

    echo json_encode([
        'exito'          => true,
        'codigo'         => $orderNumber,
        'order_id'       => $orderId,
        'payment_id'     => $paymentId,
        'pse_url'        => $pseURL,
        'transaction_id' => $transactionId,
        'mensaje'        => 'Pedido creado. Redirigiendo a PSE...',
    ]);
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    log_pago('ERROR CATCH: ' . $e->getMessage());
    log_pago('ERROR TRACE: ' . $e->getTraceAsString());

    ob_end_clean();

    http_response_code(500);
    echo json_encode(['exito' => false, 'mensaje' => $e->getMessage()]);
    exit;
}

$warnings = ob_get_clean();
if (!empty(trim($warnings))) {
    log_pago('PHP OUTPUT CAPTURADO', $warnings);
}
