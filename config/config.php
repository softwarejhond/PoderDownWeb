<?php
// ============================================================
// config/config.php — Configuración central del proyecto
// QA: credenciales via .env, DEBUG_MODE seguro, CORS restringido
// ============================================================

// ── Cargar .env si existe (producción) ──────────────────────
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            [$key, $val] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($val, " \t\n\r\0\x0B\"'");
        }
    }
}

// Helper: leer de .env o fallback
function env(string $key, string $default = ''): string {
    return $_ENV[$key] ?? $default;
}

// ── MODO MOCK ────────────────────────────────────────────────
define('MOCK_MODE', filter_var(env('MOCK_MODE', 'false'), FILTER_VALIDATE_BOOLEAN));

// ── BASE DE DATOS ────────────────────────────────────────────
define('DB_HOST',    env('DB_HOST',    '127.0.0.1'));
define('DB_PORT',    env('DB_PORT',    '8889'));
define('DB_NAME',    env('DB_NAME',    'ecommerce'));
define('DB_USER',    env('DB_USER',    'root'));
define('DB_PASS',    env('DB_PASS',    'root'));
define('DB_CHARSET', 'utf8mb4');

// ── URLs ──────────────────────────────────────────────────────
// Detectar automáticamente en producción; fallback a .env/default
$detectedBase = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
    . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
    . rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/\\');

define('BASE_URL',  rtrim(env('BASE_URL', $detectedBase), '/'));
define('BASE_PATH', __DIR__ . '/..');
define('API_URL',   BASE_URL . '/api');

// ── CORS — dominio permitido ──────────────────────────────────
define('ALLOWED_ORIGIN', env('ALLOWED_ORIGIN', BASE_URL));

// ── APLICACIÓN ───────────────────────────────────────────────
define('APP_NAME',    'Poder Down');
define('APP_VERSION', '1.0.0');
define('APP_LOCALE',  'es_CO');

date_default_timezone_set('America/Bogota');

// ── DEBUG: SIEMPRE false en producción ───────────────────────
define('DEBUG_MODE', filter_var(env('DEBUG_MODE', 'false'), FILTER_VALIDATE_BOOLEAN));

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// ── RATE LIMITING (simple, basado en sesión) ──────────────────
define('RATE_LIMIT_ORDERS',   5);   // máx pedidos por IP por hora
define('RATE_LIMIT_WINDOW',   3600);