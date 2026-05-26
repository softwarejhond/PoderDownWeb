<?php
// ============================================================
// index.php — Raíz del proyecto
// Redirige al visitante a la landing page pública
// ============================================================
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/public/landing.php');
exit;
