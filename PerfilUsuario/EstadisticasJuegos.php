<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}

require_once __DIR__ . '/../Conexion.php';

$userId = $_SESSION["user_id"] ?? 0;

try {
    $stmt = $conn->prepare("SELECT id, titulo, autor, categoria, anio, visualizaciones, created_at FROM bibliotecajuegos WHERE user_id = :uid ORDER BY visualizaciones DESC, created_at DESC");
    $stmt->execute([':uid' => $userId]);
    $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $juegos = [];
}

$totalVisitas = array_sum(array_column($juegos, 'visualizaciones'));
$totalJuegos = count($juegos);

require __DIR__ . DIRECTORY_SEPARATOR . "EstadisticasJuegosphp.php";
