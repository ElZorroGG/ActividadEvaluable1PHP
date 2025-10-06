<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: login.php");
    exit;
}
require_once "Conexion.php";

$userId = (int)($_SESSION["user_id"] ?? 0);

try {
    $stmtAll = $conn->query("SELECT * FROM bibliotecajuegos ORDER BY id DESC");
    $todos = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $todos = [];
}

try {
    $stmtMine = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE user_id = :uid ORDER BY id DESC");
    $stmtMine->execute([":uid" => $userId]);
    $mios = $stmtMine->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $mios = [];
}

$games = ["todos" => $todos, "mios" => $mios];
require "VerJuegos.php";
