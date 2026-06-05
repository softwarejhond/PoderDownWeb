<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$reqMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($reqMethod === 'OPTIONS') { http_response_code(204); exit; }

require __DIR__ . '/../../controller/conexion.php';

/* ─── Configurable image base URL ───
   En desarrollo apunta al directorio donde están las imágenes.
   En producción cambia al dominio CDN correspondiente.           */
define('IMAGES_BASE_URL', '/PODER-DOWN/');
// define('IMAGES_BASE_URL', 'https://cdn.poderdown.com/');

$action = $_GET['action'] ?? '';

switch ($action) {

    /* ─────────────── CATEGORÍAS ─────────────── */
    case 'categories':
        $sql = "SELECT c.id, c.parent_id, c.name, c.slug, c.description, c.image, c.icon,
                       c.sort_order, c.is_featured, c.is_active,
                       COUNT(p.id) AS total_productos
                FROM categories c
                LEFT JOIN products p ON p.category_id = c.id AND p.is_active = 1
                WHERE c.is_active = 1
                GROUP BY c.id
                ORDER BY c.sort_order, c.name";
        $res = mysqli_query($conn, $sql);
        $cats = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $cats[] = [
                'id'              => (int)$row['id'],
                'parent_id'       => $row['parent_id'] ? (int)$row['parent_id'] : null,
                'name'            => $row['name'],
                'slug'            => $row['slug'],
                'description'     => $row['description'],
                'icon'            => $row['icon'],
                'is_featured'     => (int)$row['is_featured'],
                'total_productos' => (int)$row['total_productos'],
            ];
        }
        echo json_encode(['exito' => true, 'datos' => $cats], JSON_UNESCAPED_UNICODE);
        break;

    /* ─────────────── LISTAR PRODUCTOS ─────────────── */
    case 'products':
        $limite  = min(max((int)($_GET['limite'] ?? 12), 1), 100);
        $offset  = max((int)($_GET['offset'] ?? 0), 0);
        $busqueda = trim($_GET['busqueda'] ?? '');
        $catId   = (int)($_GET['categoria_id'] ?? 0);
        $precioMin = (isset($_GET['precio_min']) && $_GET['precio_min'] !== '') ? (float)$_GET['precio_min'] : null;
        $precioMax = (isset($_GET['precio_max']) && $_GET['precio_max'] !== '') ? (float)$_GET['precio_max'] : null;
        $soloStock = !empty($_GET['solo_stock']);
        $orden   = $_GET['orden'] ?? 'nombre';

        $where = ['p.is_active = 1'];
        $params = [];
        $types = '';

        if ($busqueda !== '') {
            $where[] = '(p.name LIKE ? OR p.short_description LIKE ? OR p.tags LIKE ?)';
            $like = "%$busqueda%";
            $params[] = $like; $params[] = $like; $params[] = $like;
            $types .= 'sss';
        }
        if ($catId > 0) {
            $where[] = '(p.category_id = ? OR c.parent_id = ?)';
            $params[] = $catId; $params[] = $catId;
            $types .= 'ii';
        }
        if ($precioMin !== null) {
            $where[] = 'p.price >= ?';
            $params[] = $precioMin;
            $types .= 'd';
        }
        if ($precioMax !== null) {
            $where[] = 'p.price <= ?';
            $params[] = $precioMax;
            $types .= 'd';
        }
        if ($soloStock) {
            $where[] = 'p.stock > 0';
        }

        $whereSQL = implode(' AND ', $where);

        // Orden
        switch ($orden) {
            case 'precio_asc':  $orderSQL = 'p.price ASC'; break;
            case 'precio_desc': $orderSQL = 'p.price DESC'; break;
            case 'nuevos':      $orderSQL = 'p.created_at DESC'; break;
            case 'antiguos':    $orderSQL = 'p.created_at ASC'; break;
            case 'vendidos':    $orderSQL = 'p.sales_count DESC'; break;
            default:            $orderSQL = 'p.name ASC';
        }

        // Total
        $countSQL = "SELECT COUNT(*) FROM products p LEFT JOIN categories c ON c.id = p.category_id WHERE $whereSQL";
        $stmt = mysqli_prepare($conn, $countSQL);
        if ($types !== '') mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $total = (int)mysqli_fetch_row(mysqli_stmt_get_result($stmt))[0];
        mysqli_stmt_close($stmt);

        // Query paginada
        $dataSQL = "SELECT p.id, p.sku, p.name, p.slug, p.description, p.short_description,
                           p.category_id, p.price, p.compare_price, p.stock, p.is_digital,
                           p.requires_shipping, p.is_featured, p.sales_count, p.tags, p.created_at,
                           c.name AS category_name, c.slug AS category_slug,
                           pi.image_path AS imagen
                    FROM products p
                    LEFT JOIN categories c ON c.id = p.category_id
                    LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                    WHERE $whereSQL
                    GROUP BY p.id
                    ORDER BY $orderSQL
                    LIMIT ? OFFSET ?";
        $stmt = mysqli_prepare($conn, $dataSQL);
        $bindTypes = $types . 'ii';
        $bindParams = array_merge($params, [$limite, $offset]);
        if ($types !== '') {
            mysqli_stmt_bind_param($stmt, $bindTypes, ...$bindParams);
        } else {
            mysqli_stmt_bind_param($stmt, 'ii', $limite, $offset);
        }
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $prods = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $prods[] = [
                'id'               => (int)$row['id'],
                'sku'              => $row['sku'],
                'nombre'           => $row['name'],
                'slug'             => $row['slug'],
                'descripcion'      => $row['description'],
                'descripcion_corta'=> $row['short_description'],
                'categoria_id'     => (int)$row['category_id'],
                'categoria'        => $row['category_name'],
                'categoria_slug'   => $row['category_slug'],
                'precio'           => (float)$row['price'],
                'precio_compare'   => $row['compare_price'] ? (float)$row['compare_price'] : null,
                'stock'            => (int)$row['stock'],
                'stock_agotado'    => (int)$row['stock'] === 0,
                'is_digital'       => (int)$row['is_digital'],
                'requiere_envio'   => (int)$row['requires_shipping'],
                'destacado'        => (int)$row['is_featured'],
                'ventas'           => (int)$row['sales_count'],
                'tags'             => $row['tags'],
                'imagen'           => $row['imagen'] ? (IMAGES_BASE_URL . $row['imagen']) : null,
            ];
        }
        mysqli_stmt_close($stmt);

        echo json_encode([
            'exito' => true,
            'datos' => $prods,
            'total' => $total,
            'offset' => $offset,
            'limite' => $limite,
        ], JSON_UNESCAPED_UNICODE);
        break;

    /* ─────────────── PRODUCTO INDIVIDUAL ─────────────── */
    case 'product':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID inválido']);
            break;
        }
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                       pi.image_path AS imagen
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                WHERE p.id = ? AND p.is_active = 1
                LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if (!$row) {
            echo json_encode(['exito' => false, 'mensaje' => 'Producto no encontrado']);
            break;
        }

        echo json_encode([
            'exito' => true,
            'datos' => [[
                'id'               => (int)$row['id'],
                'sku'              => $row['sku'],
                'nombre'           => $row['name'],
                'slug'             => $row['slug'],
                'descripcion'      => $row['description'],
                'descripcion_corta'=> $row['short_description'],
                'categoria_id'     => (int)$row['category_id'],
                'categoria'        => $row['category_name'],
                'categoria_slug'   => $row['category_slug'],
                'precio'           => (float)$row['price'],
                'precio_compare'   => $row['compare_price'] ? (float)$row['compare_price'] : null,
                'stock'            => (int)$row['stock'],
                'stock_agotado'    => (int)$row['stock'] === 0,
                'is_digital'       => (int)$row['is_digital'],
                'requiere_envio'   => (int)$row['requires_shipping'],
                'destacado'        => (int)$row['is_featured'],
                'ventas'           => (int)$row['sales_count'],
                'tags'             => $row['tags'],
                'imagen'           => $row['imagen'] ? (IMAGES_BASE_URL . $row['imagen']) : null,
            ]]
        ], JSON_UNESCAPED_UNICODE);
        break;

    /* ─────────────── IMÁGENES DE UN PRODUCTO ─────────────── */
    case 'product_images':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID inválido']);
            break;
        }
        $sql = "SELECT id, image_path, alt_text, sort_order, is_primary
                FROM product_images
                WHERE product_id = ?
                ORDER BY sort_order ASC, id ASC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $images = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $images[] = [
                'id'        => (int)$row['id'],
                'url'       => $row['image_path'] ? IMAGES_BASE_URL . $row['image_path'] : null,
                'alt'       => $row['alt_text'],
                'orden'     => (int)$row['sort_order'],
                'principal' => (int)$row['is_primary'],
            ];
        }
        mysqli_stmt_close($stmt);
        echo json_encode(['exito' => true, 'datos' => $images], JSON_UNESCAPED_UNICODE);
        break;

    default:
        echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida. Usa action=categories, action=products, action=product, action=product_images']);
}

mysqli_close($conn);
