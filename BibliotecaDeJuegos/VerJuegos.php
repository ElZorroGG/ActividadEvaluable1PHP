<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}
require_once __DIR__ . '/../Conexion.php';

$userId = (int)($_SESSION["user_id"] ?? 0);
$busqueda = $_GET["q"] ?? "";
$deleted = isset($_GET["deleted"]) ? true : false;
$error = isset($_GET["error"]) ? true : false;

try {
    if (!empty($busqueda)) {
        $stmtAll = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE titulo LIKE CONCAT(:nombre, '%') ORDER BY id DESC");
        $stmtAll->execute([":nombre" => $busqueda]);
    } else {
        $stmtAll = $conn->query("SELECT * FROM bibliotecajuegos ORDER BY id DESC");
    }
    $todos = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $todos = [];
}

try {
    if (!empty($busqueda)) {
        $stmtMine = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE user_id = :uid AND titulo LIKE CONCAT(:nombre, '%') ORDER BY id DESC");
        $stmtMine->execute([":uid" => $userId, ":nombre" => $busqueda]);
    } else {
        $stmtMine = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE user_id = :uid ORDER BY id DESC");
        $stmtMine->execute([":uid" => $userId]);
    }
    $mios = $stmtMine->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $mios = [];
}

$games = ["todos" => $todos, "mios" => $mios];
require __DIR__ . DIRECTORY_SEPARATOR . "VerJuegosphp.php";
