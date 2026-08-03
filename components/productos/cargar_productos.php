<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$reqMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($reqMethod === 'OPTIONS') { http_response_code(204); exit; }

require __DIR__ . '/../../controller/conexion.php';

$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1']);
define('IMAGES_BASE_URL', $isLocal ? '/PODER-DOWN/' : 'https://dashboard.poderdown.com/');

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
                           pi.image_path AS imagen,
                           EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = p.id AND pv.is_active = 1) AS tiene_variantes
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
                'tiene_variantes'  => (int)$row['tiene_variantes'] === 1,
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

    /* ─────────────── VARIANTES DEL PRODUCTO ─────────────── */
    case 'product_variants':
        $id = (int)($_GET['product_id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID inválido']);
            break;
        }

        $sql = "SELECT
                    pv.id AS vid, pv.sku AS vsku, pv.name AS vname,
                    pv.price AS vprice, pv.compare_price AS vcompare_price,
                    pv.stock AS vstock, pv.image_id,
                    pi.image_path,
                    pva.attribute_id, pva.attribute_value_id,
                    pa.name AS aname, pa.slug AS aslug, pa.type AS atype,
                    pa.sort_order AS aorder,
                    pav.value AS avalue, pav.color_hex,
                    pav.sort_order AS val_order
                FROM product_variants pv
                INNER JOIN product_variant_attributes pva ON pva.variant_id = pv.id
                INNER JOIN product_attributes pa ON pa.id = pva.attribute_id
                INNER JOIN product_attribute_values pav ON pav.id = pva.attribute_value_id
                LEFT JOIN product_images pi ON pi.id = pv.image_id
                WHERE pv.product_id = ? AND pv.is_active = 1
                ORDER BY pa.sort_order, pav.sort_order, pv.sort_order";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $atributosMap = [];
        $atributosOrder = [];
        $valoresUnicos = [];
        $variantesMap = [];
        $variantesOrder = [];

        while ($row = mysqli_fetch_assoc($res)) {
            $aid = (int)$row['attribute_id'];
            $vid = (int)$row['vid'];
            $valueId = (int)$row['attribute_value_id'];

            if (!isset($atributosMap[$aid])) {
                $atributosMap[$aid] = [
                    'id'     => $aid,
                    'nombre' => $row['aname'],
                    'slug'   => $row['aslug'],
                    'tipo'   => $row['atype'],
                    'orden'  => (int)$row['aorder'],
                    'valores' => [],
                ];
                $atributosOrder[] = $aid;
            }

            $valKey = $aid . '_' . $valueId;
            if (!isset($valoresUnicos[$valKey])) {
                $valoresUnicos[$valKey] = [
                    'id'        => $valueId,
                    'valor'     => $row['avalue'],
                    'color_hex' => $row['color_hex'],
                    'orden'     => (int)$row['val_order'],
                ];
                $atributosMap[$aid]['valores'][] = $valueId;
            }

            if (!isset($variantesMap[$vid])) {
                $variantesMap[$vid] = [
                    'id'             => $vid,
                    'sku'            => $row['vsku'],
                    'nombre'         => $row['vname'],
                    'precio'         => $row['vprice'] !== null ? (float)$row['vprice'] : null,
                    'precio_compare' => $row['vcompare_price'] !== null ? (float)$row['vcompare_price'] : null,
                    'stock'          => (int)$row['vstock'],
                    'imagen'         => $row['image_path'] ? IMAGES_BASE_URL . $row['image_path'] : null,
                    'atributos'      => [],
                ];
                $variantesOrder[] = $vid;
            }
            $variantesMap[$vid]['atributos'][$aid] = $valueId;
        }
        mysqli_stmt_close($stmt);

        if (empty($atributosMap)) {
            echo json_encode(['exito' => true, 'datos' => ['tiene_variantes' => false]], JSON_UNESCAPED_UNICODE);
            break;
        }

        $atributos = [];
        foreach ($atributosOrder as $aid) {
            $attr = $atributosMap[$aid];
            $valores = [];
            foreach ($attr['valores'] as $vId) {
                $vKey = $aid . '_' . $vId;
                $vInfo = $valoresUnicos[$vKey];
                $disponible = false;
                foreach ($variantesMap as $var) {
                    if (isset($var['atributos'][$aid]) && $var['atributos'][$aid] === $vId && $var['stock'] > 0) {
                        $disponible = true;
                        break;
                    }
                }
                $valores[] = [
                    'id'         => $vInfo['id'],
                    'valor'      => $vInfo['valor'],
                    'color_hex'  => $vInfo['color_hex'],
                    'disponible' => $disponible,
                    'orden'      => $vInfo['orden'],
                ];
            }
            $atributos[] = [
                'id'      => $attr['id'],
                'nombre'  => $attr['nombre'],
                'slug'    => $attr['slug'],
                'tipo'    => $attr['tipo'],
                'valores' => $valores,
            ];
        }

        $variantes = [];
        foreach ($variantesOrder as $vid) {
            $variantes[] = $variantesMap[$vid];
        }

        echo json_encode([
            'exito' => true,
            'datos' => [
                'tiene_variantes' => true,
                'atributos' => $atributos,
                'variantes' => $variantes,
            ],
        ], JSON_UNESCAPED_UNICODE);
        break;

    default:
        echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida. Usa action=categories, action=products, action=product, action=product_images, action=product_variants']);
}

mysqli_close($conn);
