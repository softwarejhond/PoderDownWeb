<?php
// ============================================================
// dashboard/index.php
// Punto de entrada del dashboard del cliente
// Redirige al controlador correspondiente
// ============================================================

// Cargar config y controlador
require_once __DIR__ . '/../config/config.php';
require_once BASE_PATH . '/app/controllers/ProductoController.php';

// Instanciar controlador y ejecutar la acción del inventario
$controller = new ProductoController();
$controller->indexDashboard();
