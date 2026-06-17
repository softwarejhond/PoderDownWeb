<?php
require_once __DIR__ . '/../../controller/conexion.php';

function getLatestBlogs(int $limit = 3): array
{
    global $conn;
    $stmt = mysqli_prepare($conn, 'SELECT id, title, slug, excerpt, featured_image, author, created_at FROM blog_posts WHERE status = ? ORDER BY created_at DESC LIMIT ?');
    $status = 'published';
    mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $posts;
}

function getBlogs(int $page = 1, int $perPage = 15, string $search = ''): array
{
    global $conn;
    $offset = ($page - 1) * $perPage;

    $where = "WHERE status = 'published'";
    $params = [];
    $types = '';

    if (!empty($search)) {
        $where .= " AND (title LIKE ? OR excerpt LIKE ? OR content LIKE ?)";
        $searchParam = '%' . $search . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types = 'sss';
    }

    $sql = "SELECT id, title, slug, excerpt, featured_image, author, created_at FROM blog_posts {$where} ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $types .= 'ii';
    $params[] = $perPage;
    $params[] = $offset;

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $posts;
}

function getTotalBlogs(string $search = ''): int
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

    $sql = "SELECT COUNT(*) as total FROM blog_posts {$where}";
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

function getBlogBySlug(string $slug): ?array
{
    global $conn;
    $stmt = mysqli_prepare($conn, 'SELECT * FROM blog_posts WHERE slug = ? AND status = ?');
    $status = 'published';
    mysqli_stmt_bind_param($stmt, 'ss', $slug, $status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $post ?: null;
}
