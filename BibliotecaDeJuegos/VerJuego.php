<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/login.php");
    exit;
}
require_once __DIR__ . '/../Conexion.php';

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE id = :id LIMIT 1");
    $stmt->execute([":id" => $id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $game = false;
}

if (!$game) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

require __DIR__ . DIRECTORY_SEPARATOR . "VerJuegophp.php";
