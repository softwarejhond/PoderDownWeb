<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../controller/conexion.php';
require_once __DIR__ . '/../../controller/megapagos.php';

try {
    $megapagos = new MegapagosClient($conn);
    $raw = $megapagos->getBanks();

    $bancos = [];
    $lista = [];

    if (is_array($raw)) {
        if (isset($raw['data']) && is_array($raw['data'])) {
            $lista = $raw['data'];
        } elseif (isset($raw[0])) {
            $lista = $raw;
        } else {
            $lista = [$raw];
        }
    }

    foreach ($lista as $item) {
        if (is_string($item)) {
            $bancos[] = ['code' => '', 'name' => $item];
            continue;
        }
        if (!is_array($item)) continue;

        $code = $item['financialInstitutionCode'] ?? $item['code'] ?? $item['codigo'] ?? $item['id'] ?? $item['bankCode'] ?? $item['bank_code'] ?? $item['codigoBanco'] ?? '';
        $name = $item['financialInstitutionName'] ?? $item['name'] ?? $item['nombre'] ?? $item['banco'] ?? $item['bank'] ?? $item['bankName'] ?? $item['bank_name'] ?? $item['description'] ?? $item['descripcion'] ?? '';

        if (empty($name) && !empty($code) && count($item) === 1) {
            reset($item);
            $name = current($item);
            $code = key($item);
            if (!is_string($name)) { $name = (string) $name; }
        }

        $bancos[] = ['code' => (string) $code, 'name' => (string) $name];
    }

    echo json_encode([
        'exito' => true,
        'bancos' => $bancos,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['exito' => false, 'mensaje' => $e->getMessage()]);
}
