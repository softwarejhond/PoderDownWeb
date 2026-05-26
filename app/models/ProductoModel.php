<?php
// ============================================================
// app/models/ProductoModel.php
// MODELO: Producto — Lectura + Escritura (CRUD completo)
// ============================================================

require_once BASE_PATH . '/config/Database.php';

class ProductoModel
{
    private PDO    $db;
    private string $tabla = 'productos';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // ── LECTURA ──────────────────────────────────────────────

    public function obtenerTodos(array $filtros = []): array
    {
        // Incluye activo=0 también para el dashboard (todos los estados)
        $soloActivos = $filtros['solo_activos'] ?? true;

        $sql = "
            SELECT p.id, p.nombre, p.descripcion, p.precio,
                   p.stock, p.imagen, p.activo, p.categoria_id,
                   p.created_at, p.updated_at,
                   c.nombre AS categoria
            FROM {$this->tabla} p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE 1=1
        ";
        if ($soloActivos) $sql .= " AND p.activo = 1";

        $params = [];

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtros['categoria_id'];
        }
        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtros['busqueda'] . '%';
        }

        $ordenesPermitidos = [
            'p.nombre ASC','p.nombre DESC',
            'p.precio ASC','p.precio DESC',
            'p.stock ASC', 'p.stock DESC',
            'p.created_at DESC'
        ];
        $orden = $filtros['orden'] ?? 'p.created_at DESC';
        $sql  .= in_array($orden, $ordenesPermitidos) ? " ORDER BY {$orden}" : " ORDER BY p.created_at DESC";

        if (!empty($filtros['limite'])) {
            $limite = (int) $filtros['limite'];
            $offset = (int) ($filtros['offset'] ?? 0);
            $sql .= " LIMIT {$limite} OFFSET {$offset}";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT p.*, c.nombre AS categoria
                FROM {$this->tabla} p
                INNER JOIN categorias c ON c.id = p.categoria_id
                WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function contarTodos(array $filtros = []): int
    {
        $soloActivos = $filtros['solo_activos'] ?? true;
        $sql = "SELECT COUNT(*) AS total FROM {$this->tabla} p WHERE 1=1";
        if ($soloActivos) $sql .= " AND p.activo = 1";

        $params = [];
        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtros['categoria_id'];
        }
        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtros['busqueda'] . '%';
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['total'];
    }

    public function resumenInventario(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                COUNT(*)                                          AS total_productos,
                SUM(stock)                                        AS total_stock,
                SUM(precio * stock)                               AS valor_inventario,
                COUNT(CASE WHEN stock = 0       THEN 1 END)       AS sin_stock,
                COUNT(CASE WHEN stock <= 5 AND stock > 0 THEN 1 END) AS stock_bajo
            FROM {$this->tabla} WHERE activo = 1
        ");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function obtenerPorCategoria(): array
    {
        $stmt = $this->db->prepare("
            SELECT c.id, c.nombre AS categoria,
                   COUNT(p.id) AS cantidad, SUM(p.stock) AS stock_total
            FROM {$this->tabla} p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.activo = 1
            GROUP BY c.id, c.nombre ORDER BY cantidad DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerCategorias(): array
    {
        $stmt = $this->db->prepare("SELECT id, nombre FROM categorias WHERE activo = 1 ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ── ESCRITURA ─────────────────────────────────────────────

    // Crear producto nuevo
    public function crear(array $datos): int
    {
        $sql = "
            INSERT INTO {$this->tabla}
                (categoria_id, nombre, descripcion, precio, stock, imagen, activo)
            VALUES
                (:categoria_id, :nombre, :descripcion, :precio, :stock, :imagen, :activo)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':categoria_id' => (int)   $datos['categoria_id'],
            ':nombre'       =>          $datos['nombre'],
            ':descripcion'  =>          $datos['descripcion'] ?? '',
            ':precio'       => (float)  $datos['precio'],
            ':stock'        => (int)    $datos['stock'],
            ':imagen'       =>          $datos['imagen'] ?? 'default.jpg',
            ':activo'       => (int)   ($datos['activo'] ?? 1),
        ]);
        return (int) $this->db->lastInsertId();
    }

    // Actualizar todos los campos de un producto
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "
            UPDATE {$this->tabla} SET
                categoria_id = :categoria_id,
                nombre       = :nombre,
                descripcion  = :descripcion,
                precio       = :precio,
                stock        = :stock,
                activo       = :activo
                {$this->imagenSQL($datos)}
            WHERE id = :id
        ";
        $params = [
            ':id'           => $id,
            ':categoria_id' => (int)   $datos['categoria_id'],
            ':nombre'       =>          $datos['nombre'],
            ':descripcion'  =>          $datos['descripcion'] ?? '',
            ':precio'       => (float)  $datos['precio'],
            ':stock'        => (int)    $datos['stock'],
            ':activo'       => (int)   ($datos['activo'] ?? 1),
        ];
        if (!empty($datos['imagen'])) $params[':imagen'] = $datos['imagen'];

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() >= 0;
    }

    // Cambiar solo el stock (botón rápido +/-)
    public function actualizarStock(int $id, int $nuevoStock): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->tabla} SET stock = :stock WHERE id = :id"
        );
        $stmt->execute([':stock' => max(0, $nuevoStock), ':id' => $id]);
        return $stmt->rowCount() >= 0;
    }

    // Activar / desactivar (soft delete)
    public function cambiarEstado(int $id, int $activo): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->tabla} SET activo = :activo WHERE id = :id"
        );
        $stmt->execute([':activo' => $activo, ':id' => $id]);
        return $stmt->rowCount() >= 0;
    }

    // Eliminación física permanente
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->tabla} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Helper privado: añade imagen al UPDATE solo si viene nueva
    private function imagenSQL(array $datos): string
    {
        return !empty($datos['imagen']) ? ', imagen = :imagen' : '';
    }
}
