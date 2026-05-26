<?php
// ============================================================
// app/helpers/ApiHelper.php
// Helper: respuestas JSON estandarizadas para la API REST
// Todas las respuestas de la API deben pasar por aquí
// ============================================================

class ApiHelper
{
    // ------------------------------------------------------------
    // responder($datos, $codigo)
    // Envía una respuesta JSON con el código HTTP indicado
    // $datos  → array con la información a retornar
    // $codigo → código HTTP (200, 201, 400, 404, 500...)
    // ------------------------------------------------------------
    public static function responder(array $datos, int $codigo = 200): void
    {
        // Cabeceras CORS y tipo de contenido
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        // Responder preflight CORS (peticiones OPTIONS)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        http_response_code($codigo);
        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // ------------------------------------------------------------
    // exito($datos, $mensaje, $codigo)
    // Respuesta estándar de éxito
    // ------------------------------------------------------------
    public static function exito(array $datos = [], string $mensaje = 'OK', int $codigo = 200): void
    {
        self::responder([
            'exito'   => true,
            'mensaje' => $mensaje,
            'datos'   => $datos,
            'total'   => count($datos),
        ], $codigo);
    }

    // ------------------------------------------------------------
    // error($mensaje, $codigo)
    // Respuesta estándar de error
    // ------------------------------------------------------------
    public static function error(string $mensaje = 'Error interno', int $codigo = 500): void
    {
        self::responder([
            'exito'   => false,
            'mensaje' => $mensaje,
            'datos'   => [],
        ], $codigo);
    }

    // ------------------------------------------------------------
    // validarMetodo($metodo)
    // Termina la ejecución si el método HTTP no coincide
    // Uso: ApiHelper::validarMetodo('GET');
    // ------------------------------------------------------------
    public static function validarMetodo(string $metodo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== strtoupper($metodo)) {
            self::error("Método no permitido. Se esperaba {$metodo}.", 405);
        }
    }
}
