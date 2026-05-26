<?php
// ============================================================
// config/config.php
// Configuración central del proyecto
// ============================================================

// ------------------------------------------------------------
// MODO MOCK (DATOS DE PRUEBA — SIN BASE DE DATOS)
// true  → La API responde con JSON estático incorporado
//         Funciona sin MAMP, sin MySQL, sin nada instalado
// false → La API usa MySQL real (requiere MAMP + SQL importado)
// ------------------------------------------------------------
define('MOCK_MODE', false);  // ← false = MySQL real (MAMP activo)

// ------------------------------------------------------------
// BASE DE DATOS (solo se usa cuando MOCK_MODE = false)
// MAMP Mac:    puerto 8889, pass root
// MAMP Win:    puerto 3306, pass root
// XAMPP:       puerto 3306, pass vacío ''
// ------------------------------------------------------------
define('DB_HOST', '127.0.0.1'); // 🔥 aquí está la corrección
define('DB_PORT', '8889');
define('DB_NAME', 'ecommerce');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_CHARSET', 'utf8mb4');

// ------------------------------------------------------------
// URLs Y RUTAS
// Ajusta BASE_URL según tu configuración de MAMP
// ------------------------------------------------------------
define('BASE_URL',    'http://localhost:8888/ecommerce2');
define('BASE_PATH', __DIR__ . '/..');
define('API_URL',   BASE_URL . '/api');

// ------------------------------------------------------------
// CONFIGURACIÓN GENERAL
// ------------------------------------------------------------
define('APP_NAME',    'Día a Día con Cami');
define('APP_VERSION', '1.0.0');
define('APP_LOCALE',  'es_CO');

date_default_timezone_set('America/Bogota');

// ------------------------------------------------------------
// MODO DEBUG
// ------------------------------------------------------------
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}
