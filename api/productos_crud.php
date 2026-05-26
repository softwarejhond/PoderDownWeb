<?php
// ============================================================
// api/productos_crud.php
// ENDPOINT DE ESCRITURA: crear, editar, stock, estado, eliminar
//
// Métodos:
//   POST   + action=crear        → Nuevo producto
//   POST   + action=actualizar   → Editar producto completo
//   POST   + action=stock        → Cambiar stock (+/- o valor exacto)
//   POST   + action=estado       → Activar / desactivar
//   POST   + action=eliminar     → Eliminar permanente
//   POST   + action=subir_imagen → Upload de imagen
//
// Nota: se usa POST para todo porque FormData con archivos
//       no funciona bien con PUT en PHP nativo.
// ============================================================

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/ApiHelper.php';

// Cabeceras CORS
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

ApiHelper::validarMetodo('POST');

$action = trim($_POST['action'] ?? '');
if (!$action) ApiHelper::error('Falta el parámetro action.', 400);

// ============================================================
// MODO MOCK — simula escritura en memoria (sin BD)
// En modo mock los cambios NO persisten entre recargas,
// pero el flujo completo queda demostrado visualmente.
// ============================================================
if (MOCK_MODE) {
    require_once __DIR__ . '/mock_data.php';

    switch ($action) {

        case 'crear':
            $nuevo = [
                'id'          => rand(100, 999),
                'nombre'      => $_POST['nombre']      ?? 'Nuevo producto',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio'      => (float) ($_POST['precio'] ?? 0),
                'stock'       => (int)   ($_POST['stock']  ?? 0),
                'categoria'   => $_POST['categoria_nombre'] ?? 'Sin categoría',
                'imagen'      => 'default.jpg',
                'activo'      => 1,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            ApiHelper::exito([$nuevo], 'Producto creado (modo prueba — no persiste)', 201);
            break;

        case 'actualizar':
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) ApiHelper::error('ID requerido.', 400);
            ApiHelper::exito([], 'Producto #' . $id . ' actualizado (modo prueba — no persiste)');
            break;

        case 'stock':
            $id    = (int) ($_POST['id']    ?? 0);
            $delta = (int) ($_POST['delta'] ?? 0);   // +N o -N
            $exact = isset($_POST['stock_exacto']) ? (int)$_POST['stock_exacto'] : null;
            if (!$id) ApiHelper::error('ID requerido.', 400);

            $todos    = getMockProductos();
            $producto = current(array_filter($todos, fn($p) => $p['id'] === $id));
            $nuevoStock = $exact !== null
                ? max(0, $exact)
                : max(0, ($producto['stock'] ?? 0) + $delta);

            ApiHelper::exito(['nuevo_stock' => $nuevoStock], 'Stock actualizado (modo prueba)');
            break;

        case 'estado':
            $id     = (int) ($_POST['id']     ?? 0);
            $activo = (int) ($_POST['activo'] ?? 1);
            if (!$id) ApiHelper::error('ID requerido.', 400);
            ApiHelper::exito(['activo' => $activo], 'Estado actualizado (modo prueba)');
            break;

        case 'eliminar':
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) ApiHelper::error('ID requerido.', 400);
            ApiHelper::exito([], 'Producto #' . $id . ' eliminado (modo prueba)');
            break;

        case 'subir_imagen':
            // En modo mock devolvemos un nombre ficticio
            ApiHelper::exito(['imagen' => 'imagen_mock.jpg'], 'Imagen subida (modo prueba)');
            break;

        default:
            ApiHelper::error("Acción '{$action}' no reconocida.", 400);
    }

    exit;
}

// ============================================================
// MODO REAL — operaciones MySQL
// ============================================================
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/models/ProductoModel.php';

$modelo = new ProductoModel();

try {
    switch ($action) {

        // ── CREAR ──────────────────────────────────────────
        case 'crear':
            $errores = validarCampos(['nombre','categoria_id','precio','stock']);
            if ($errores) ApiHelper::error(implode(', ', $errores), 422);

            // Subir imagen si viene
            $nombreImagen = subirImagen();

            $id = $modelo->crear([
                'categoria_id' => (int)   $_POST['categoria_id'],
                'nombre'       =>          trim($_POST['nombre']),
                'descripcion'  =>          trim($_POST['descripcion'] ?? ''),
                'precio'       => (float)  $_POST['precio'],
                'stock'        => (int)    $_POST['stock'],
                'imagen'       =>          $nombreImagen ?: 'default.jpg',
                'activo'       => 1,
            ]);

            $producto = $modelo->obtenerPorId($id);
            ApiHelper::exito([$producto], 'Producto creado correctamente.', 201);
            break;

        // ── ACTUALIZAR ─────────────────────────────────────
        case 'actualizar':
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) ApiHelper::error('ID requerido.', 400);

            $errores = validarCampos(['nombre','categoria_id','precio','stock']);
            if ($errores) ApiHelper::error(implode(', ', $errores), 422);

            // Subir nueva imagen solo si viene archivo
            $nombreImagen = subirImagen();

            $datos = [
                'categoria_id' => (int)   $_POST['categoria_id'],
                'nombre'       =>          trim($_POST['nombre']),
                'descripcion'  =>          trim($_POST['descripcion'] ?? ''),
                'precio'       => (float)  $_POST['precio'],
                'stock'        => (int)    $_POST['stock'],
                'activo'       => (int)   ($_POST['activo'] ?? 1),
            ];
            if ($nombreImagen) $datos['imagen'] = $nombreImagen;

            $modelo->actualizar($id, $datos);
            $producto = $modelo->obtenerPorId($id);
            ApiHelper::exito([$producto], 'Producto actualizado correctamente.');
            break;

        // ── STOCK RÁPIDO ───────────────────────────────────
        case 'stock':
            $id    = (int) ($_POST['id']    ?? 0);
            $delta = (int) ($_POST['delta'] ?? 0);
            $exact = isset($_POST['stock_exacto']) ? (int)$_POST['stock_exacto'] : null;
            if (!$id) ApiHelper::error('ID requerido.', 400);

            $producto = $modelo->obtenerPorId($id);
            if (!$producto) ApiHelper::error('Producto no encontrado.', 404);

            $nuevoStock = $exact !== null
                ? max(0, $exact)
                : max(0, (int)$producto['stock'] + $delta);

            $modelo->actualizarStock($id, $nuevoStock);
            ApiHelper::exito(['nuevo_stock' => $nuevoStock], 'Stock actualizado.');
            break;

        // ── ACTIVAR / DESACTIVAR ───────────────────────────
        case 'estado':
            $id     = (int) ($_POST['id']     ?? 0);
            $activo = (int) ($_POST['activo'] ?? 1);
            if (!$id) ApiHelper::error('ID requerido.', 400);
            $modelo->cambiarEstado($id, $activo ? 1 : 0);
            ApiHelper::exito(['activo' => $activo], 'Estado actualizado.');
            break;

        // ── ELIMINAR ───────────────────────────────────────
        case 'eliminar':
            $id = (int) ($_POST['id'] ?? 0);
            if (!$id) ApiHelper::error('ID requerido.', 400);

            // Obtener imagen para borrarla del disco
            $producto = $modelo->obtenerPorId($id);
            $modelo->eliminar($id);

            // Borrar imagen si existe y no es la default
            if ($producto && $producto['imagen'] !== 'default.jpg') {
                $ruta = BASE_PATH . '/public/img/productos/' . $producto['imagen'];
                if (file_exists($ruta)) @unlink($ruta);
            }

            ApiHelper::exito([], 'Producto eliminado permanentemente.');
            break;

        // ── SUBIR IMAGEN SUELTA ────────────────────────────
        case 'subir_imagen':
            $nombre = subirImagen();
            if (!$nombre) ApiHelper::error('No se recibió imagen o el archivo no es válido.', 400);

            // Actualizar imagen en BD si viene ID
            if (!empty($_POST['id'])) {
                $id = (int) $_POST['id'];
                $modelo->actualizar($id, ['imagen' => $nombre,
                    // Campos requeridos — se obtienen del producto actual
                    ...array_intersect_key(
                        $modelo->obtenerPorId($id) ?: [],
                        array_flip(['categoria_id','nombre','descripcion','precio','stock','activo'])
                    )
                ]);
            }
            ApiHelper::exito(['imagen' => $nombre], 'Imagen subida correctamente.');
            break;

        default:
            ApiHelper::error("Acción '{$action}' no reconocida.", 400);
    }

} catch (Exception $e) {
    $msg = DEBUG_MODE ? $e->getMessage() : 'Error al procesar la solicitud.';
    ApiHelper::error($msg, 500);
}

// ============================================================
// HELPERS LOCALES
// ============================================================

// Valida que los campos POST requeridos no estén vacíos
function validarCampos(array $campos): array
{
    $errores = [];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo]) && $_POST[$campo] !== '0') {
            $errores[] = "El campo '{$campo}' es requerido";
        }
    }
    return $errores;
}

// Sube la imagen de $_FILES['imagen'] y retorna el nombre guardado
function subirImagen(): string
{
    if (empty($_FILES['imagen']['tmp_name'])) return '';

    $archivo   = $_FILES['imagen'];
    $ext       = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg','jpeg','png','webp','gif'];

    if (!in_array($ext, $permitidos)) return '';
    if ($archivo['size'] > 5 * 1024 * 1024) return ''; // Max 5MB

    $nombre  = 'prod_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $destino = BASE_PATH . '/public/img/productos/' . $nombre;

    if (!is_dir(dirname($destino))) {
        mkdir(dirname($destino), 0755, true);
    }

    return move_uploaded_file($archivo['tmp_name'], $destino) ? $nombre : '';
}
