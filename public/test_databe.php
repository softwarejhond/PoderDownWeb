<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=8889;dbname=ecommerce", "root", "root");
    echo "✅ Conectado";
} catch (Exception $e) {
    echo "❌ " . $e->getMessage();
}