<?php
// ============================================================
// app/helpers/ApiHelper.php
// QA: CORS restringido, security headers, sanitización
// ============================================================

class ApiHelper
{
    // ── Cabeceras de seguridad ────────────────────────────────
    public static function setCorsHeaders(): void
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        $allowed = defined('ALLOWED_ORIGIN') ? ALLOWED_ORIGIN : BASE_URL;

        // Solo permite el origen configurado (o mismo dominio)
        if ($origin === $allowed || empty($origin)) {
            header('Access-Control-Allow-Origin: ' . ($origin ?: $allowed));
        }
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Max-Age: 86400');
        header('Vary: Origin');
    }

    public static function setSecurityHeaders(): void
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Cache-Control: no-store, no-cache, must-revalidate');
    }

    public static function setHeaders(): void
    {
        self::setCorsHeaders();
        self::setSecurityHeaders();
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }

    // ── Respuestas ────────────────────────────────────────────
    public static function responder(array $datos, int $codigo = 200): void
    {
        self::setHeaders();
        http_response_code($codigo);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function exito(array $datos = [], string $mensaje = 'OK', int $codigo = 200): void
    {
        self::responder([
            'exito'   => true,
            'mensaje' => $mensaje,
            'datos'   => $datos,
            'total'   => count($datos),
        ], $codigo);
    }

    public static function error(string $mensaje = 'Error interno', int $codigo = 500): void
    {
        self::responder([
            'exito'   => false,
            'mensaje' => $mensaje,
            'datos'   => [],
        ], $codigo);
    }

    public static function validarMetodo(string $metodo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== strtoupper($metodo)) {
            self::error("Método no permitido.", 405);
        }
    }

    // ── Sanitización ─────────────────────────────────────────
    public static function sanitizeString(string $val, int $maxLen = 255): string
    {
        $val = strip_tags(trim($val));
        $val = htmlspecialchars($val, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return mb_substr($val, 0, $maxLen, 'UTF-8');
    }

    public static function sanitizeEmail(string $val): string
    {
        return filter_var(trim($val), FILTER_SANITIZE_EMAIL);
    }

    // ── Rate Limiting por IP (archivo-based) ─────────────────
    public static function checkRateLimit(string $action, int $max, int $window): void
    {
        $ip      = md5($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $dir     = sys_get_temp_dir() . '/pd_rl';
        if (!is_dir($dir)) mkdir($dir, 0700, true);
        $file    = $dir . '/' . $action . '_' . $ip . '.json';

        $data    = ['count' => 0, 'reset' => time() + $window];
        if (file_exists($file)) {
            $raw = json_decode(file_get_contents($file), true);
            if ($raw && $raw['reset'] > time()) {
                $data = $raw;
            }
        }

        if ($data['count'] >= $max) {
            self::error('Demasiadas solicitudes. Intenta más tarde.', 429);
        }

        $data['count']++;
        file_put_contents($file, json_encode($data), LOCK_EX);
    }
}