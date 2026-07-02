<?php
require_once __DIR__ . '/../../controller/conexion.php';

function getLatestGalerias(int $limit = 3): array
{
    global $conn;
    $stmt = mysqli_prepare($conn, 'SELECT g.id, g.title, g.slug, g.excerpt, g.featured_image, COALESCE(u.nombre, g.author) AS author, g.created_at FROM galerias g LEFT JOIN users u ON u.username = g.author WHERE g.status = ? ORDER BY g.created_at DESC LIMIT ?');
    $status = 'published';
    mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $galerias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $galerias[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $galerias;
}

function getGalerias(int $page = 1, int $perPage = 15, string $search = ''): array
{
    global $conn;
    $offset = ($page - 1) * $perPage;

    $where = "WHERE g.status = 'published'";
    $params = [];
    $types = '';

    if (!empty($search)) {
        $where .= " AND (g.title LIKE ? OR g.excerpt LIKE ?)";
        $searchParam = '%' . $search . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types = 'ss';
    }

    $sql = "SELECT g.id, g.title, g.slug, g.excerpt, g.featured_image, COALESCE(u.nombre, g.author) AS author, g.created_at, (SELECT COUNT(*) FROM galeria_obras o WHERE o.galeria_id = g.id) AS total_obras FROM galerias g LEFT JOIN users u ON u.username = g.author {$where} ORDER BY g.created_at DESC LIMIT ? OFFSET ?";
    $types .= 'ii';
    $params[] = $perPage;
    $params[] = $offset;

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $galerias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $galerias[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $galerias;
}

function getTotalGalerias(string $search = ''): int
{
    global $conn;
    $where = "WHERE status = 'published'";
    $params = [];
    $types = '';

    if (!empty($search)) {
        $where .= " AND (title LIKE ? OR excerpt LIKE ?)";
        $searchParam = '%' . $search . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types = 'ss';
    }

    $sql = "SELECT COUNT(*) as total FROM galerias {$where}";
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($types)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return (int) ($row['total'] ?? 0);
}

function getGaleriaObras(int $galeriaId): array
{
    global $conn;
    $stmt = mysqli_prepare($conn, 'SELECT id, img, title, meta, descripcion, sort_order FROM galeria_obras WHERE galeria_id = ? ORDER BY sort_order ASC, id ASC');
    mysqli_stmt_bind_param($stmt, 'i', $galeriaId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $obras = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $obras[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $obras;
}

function getGaleriaBySlug(string $slug): ?array
{
    global $conn;
    $stmt = mysqli_prepare($conn, 'SELECT g.*, COALESCE(u.nombre, g.author) AS author FROM galerias g LEFT JOIN users u ON u.username = g.author WHERE g.slug = ? AND g.status = ?');
    $status = 'published';
    mysqli_stmt_bind_param($stmt, 'ss', $slug, $status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $galeria = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$galeria) {
        return null;
    }

    $galeria['obras'] = getGaleriaObras((int) $galeria['id']);
    return $galeria;
}
