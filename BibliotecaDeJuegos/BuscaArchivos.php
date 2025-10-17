<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/login.php");
    exit;
}
require_once __DIR__ . '/../Conexion.php';
$q = $_GET["q"] ?? '';

try {
    $stmtAll = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE titulo LIKE CONCAT(:nombre, '%') ORDER BY id DESC");
    $stmtAll->execute([":nombre" => $q]);
    $games = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $games = [];
}

foreach ($games as $game) {
    $img = $game['caratula'] ?? '/ActividadEvaluable1PHP/CaratulaPorDefecto/fc10656866244f57fe4aec109c76c84474539fef6ef3e066cf177edea6185202_749a89.png';
    
    if (!preg_match('/^(https?:)?\/\//', $img) && strpos($img, '/') !== 0) {
        $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
    }
    
    $titulo = $game['titulo'] ?? '';
    $autor = $game['autor'] ?? '';
    $id = $game['id'];
    
    echo '<a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=' . $id . '" style="--bg-url: url(\'' . $img . '\');">';
    echo '<div class="meta-overlay">';
    echo '<div class="meta">';
    echo '<div class="title">' . $titulo . '</div>';
    echo '<div class="author small">' . $autor . '</div>';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
?>