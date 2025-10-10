<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/login.php");
    exit;
}
require(__DIR__ . '/../Conexion.php');
$q=$_GET["q"];
try {
    $stmtAll = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE titulo like :nombre'%' ORDER BY id DESC");
    $stmtAll->execute([":nombre" => $q]);
    $games = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $games = [];
}
echo json_encode($games);
?>