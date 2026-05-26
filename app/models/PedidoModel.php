<?php
// ============================================================
// app/models/PedidoModel.php
// MODELO: Pedidos — sin registro de usuario
// ============================================================
require_once BASE_PATH . '/config/Database.php';

class PedidoModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Genera código único tipo PD-2026-XXXX
    public function generarCodigo(): string
    {
        do {
            $codigo = 'PD-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $stmt = $this->db->prepare("SELECT id FROM pedidos WHERE codigo = :c LIMIT 1");
            $stmt->execute([':c' => $codigo]);
        } while ($stmt->fetch());
        return $codigo;
    }

    // Crear pedido + sus items + descontar stock
    public function crear(array $datos, array $items): int
    {
        $this->db->beginTransaction();
        try {
            $codigo = $this->generarCodigo();
            $total  = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $items));

            $stmt = $this->db->prepare("
                INSERT INTO pedidos (codigo, nombre, email, telefono, ciudad, direccion, notas, total)
                VALUES (:codigo, :nombre, :email, :telefono, :ciudad, :direccion, :notas, :total)
            ");
            $stmt->execute([
                ':codigo'    => $codigo,
                ':nombre'    => trim($datos['nombre']),
                ':email'     => trim($datos['email']),
                ':telefono'  => trim($datos['telefono']),
                ':ciudad'    => trim($datos['ciudad']),
                ':direccion' => trim($datos['direccion']),
                ':notas'     => trim($datos['notas'] ?? ''),
                ':total'     => $total,
            ]);
            $pedidoId = (int) $this->db->lastInsertId();

            $stmtItem = $this->db->prepare("
                INSERT INTO pedido_items (pedido_id, producto_id, nombre, precio, cantidad, subtotal)
                VALUES (:pedido_id, :producto_id, :nombre, :precio, :cantidad, :subtotal)
            ");
            $stmtStock = $this->db->prepare("
                UPDATE productos SET stock = GREATEST(0, stock - :cantidad) WHERE id = :id
            ");

            foreach ($items as $item) {
                $stmtItem->execute([
                    ':pedido_id'   => $pedidoId,
                    ':producto_id' => (int) $item['id'],
                    ':nombre'      => $item['nombre'],
                    ':precio'      => (float) $item['precio'],
                    ':cantidad'    => (int) $item['cantidad'],
                    ':subtotal'    => (float) $item['precio'] * (int) $item['cantidad'],
                ]);
                $stmtStock->execute([
                    ':cantidad' => (int) $item['cantidad'],
                    ':id'       => (int) $item['id'],
                ]);
            }

            $this->db->commit();
            return $pedidoId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Listar pedidos con filtros opcionales para el dashboard
    public function obtenerTodos(array $filtros = []): array
    {
        $sql    = "SELECT * FROM pedidos WHERE 1=1";
        $params = [];

        if (!empty($filtros['estado'])) {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $filtros['estado'];
        }
        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (codigo LIKE :b OR nombre LIKE :b OR email LIKE :b OR telefono LIKE :b)";
            $params[':b'] = '%' . $filtros['busqueda'] . '%';
        }

        $sql .= " ORDER BY created_at DESC";

        if (!empty($filtros['limite'])) {
            $limite = (int) $filtros['limite'];
            $offset = (int) ($filtros['offset'] ?? 0);
            $sql   .= " LIMIT {$limite} OFFSET {$offset}";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function contar(array $filtros = []): int
    {
        $sql    = "SELECT COUNT(*) AS total FROM pedidos WHERE 1=1";
        $params = [];
        if (!empty($filtros['estado'])) { $sql .= " AND estado = :estado"; $params[':estado'] = $filtros['estado']; }
        if (!empty($filtros['busqueda'])) { $sql .= " AND (codigo LIKE :b OR nombre LIKE :b OR email LIKE :b)"; $params[':b'] = '%'.$filtros['busqueda'].'%'; }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['total'];
    }

    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function obtenerItems(int $pedidoId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM pedido_items WHERE pedido_id = :id ORDER BY id");
        $stmt->execute([':id' => $pedidoId]);
        return $stmt->fetchAll();
    }

    public function cambiarEstado(int $id, string $estado): bool
    {
        $permitidos = ['pendiente','confirmado','preparando','enviado','entregado','cancelado'];
        if (!in_array($estado, $permitidos)) return false;
        $stmt = $this->db->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
        $stmt->execute([':estado' => $estado, ':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function resumen(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                COUNT(*)                                        AS total,
                COUNT(CASE WHEN estado='pendiente'   THEN 1 END) AS pendientes,
                COUNT(CASE WHEN estado='enviado'     THEN 1 END) AS enviados,
                COUNT(CASE WHEN estado='entregado'   THEN 1 END) AS entregados,
                COALESCE(SUM(total),0)                          AS ingresos_total,
                COALESCE(SUM(CASE WHEN DATE(created_at)=CURDATE() THEN total END),0) AS ingresos_hoy
            FROM pedidos WHERE estado != 'cancelado'
        ");
        $stmt->execute();
        return $stmt->fetch();
    }
}
