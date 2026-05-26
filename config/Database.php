<?php
// ============================================================
// config/Database.php
// Conexión PDO — Singleton
// NO se conecta si MOCK_MODE = true
// ============================================================

class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    private function __construct()
    {
        // Si estamos en modo mock, no intentar conectar a MySQL
        if (defined('MOCK_MODE') && MOCK_MODE === true) {
            return;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
        );

        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        } catch (PDOException $e) {
            $msg = (defined('DEBUG_MODE') && DEBUG_MODE)
                ? 'Error de conexión: ' . $e->getMessage()
                : 'No se pudo conectar a la base de datos.';
            die(json_encode(['error' => true, 'mensaje' => $msg]));
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }
}
