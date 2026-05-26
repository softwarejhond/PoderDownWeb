<?php
// ============================================================
// app/controllers/ProductoController.php
// CONTROLADOR: Producto
// MOCK_MODE=true  → datos de api/mock_data.php (sin BD)
// MOCK_MODE=false → consulta MySQL via ProductoModel
// ============================================================

class ProductoController
{
    public function indexDashboard(): void
    {
        if (MOCK_MODE) {
            require_once BASE_PATH . '/api/mock_data.php';
            $productos    = getMockProductos();
            $resumen      = getMockStats();
            $porCategoria = getMockPorCategoria();
            // Categorías para el formulario (mock)
            $categorias   = array_map(fn($c) => [
                'id' => $c['categoria'], 'nombre' => $c['categoria']
            ], $porCategoria);
            $totalItems   = count($productos);
            $totalPaginas = 1;
            $paginaActual = 1;
        } else {
            require_once BASE_PATH . '/app/models/ProductoModel.php';
            $modelo = new ProductoModel();
            $filtros = [
                'busqueda'     => trim($_GET['busqueda']   ?? ''),
                'categoria_id' => (int)($_GET['categoria'] ?? 0) ?: null,
                'orden'        => $_GET['orden']            ?? 'p.created_at DESC',
                'limite'       => 15,
                'offset'       => ((int)($_GET['pagina'] ?? 1) - 1) * 15,
                'solo_activos' => false, // Dashboard ve todos
            ];
            $productos    = $modelo->obtenerTodos($filtros);
            $totalItems   = $modelo->contarTodos($filtros);
            $resumen      = $modelo->resumenInventario();
            $porCategoria = $modelo->obtenerPorCategoria();
            $categorias   = $modelo->obtenerCategorias();
            $totalPaginas = ceil($totalItems / $filtros['limite']);
            $paginaActual = (int)($_GET['pagina'] ?? 1);
        }

        include BASE_PATH . '/app/views/dashboard/inventario.php';
    }
}
