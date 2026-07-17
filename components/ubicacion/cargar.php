<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../controller/conexion.php';

$action = $_GET['action'] ?? 'departamentos';

if ($action === 'departamentos') {
    $res = mysqli_query($conn, "SELECT id_departamento AS id, departamento AS nombre FROM departamentos ORDER BY departamento ASC");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    echo json_encode(['exito' => true, 'datos' => $data]);
} elseif ($action === 'municipios') {
    $deptoId = (int)($_GET['departamento_id'] ?? 0);
    if ($deptoId <= 0) {
        echo json_encode(['exito' => false, 'mensaje' => 'departamento_id requerido']);
        exit;
    }
    $stmt = mysqli_prepare($conn, "SELECT id_municipio AS id, municipio AS nombre FROM municipios WHERE departamento_id = ? ORDER BY municipio ASC");
    mysqli_stmt_bind_param($stmt, 'i', $deptoId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    mysqli_stmt_close($stmt);
    echo json_encode(['exito' => true, 'datos' => $data]);
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);
}
