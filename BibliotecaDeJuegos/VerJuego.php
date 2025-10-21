<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
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
    
    if ($game) {
        $stmtUpdate = $conn->prepare("UPDATE bibliotecajuegos SET visualizaciones = visualizaciones + 1 WHERE id = :id");
        $stmtUpdate->execute([":id" => $id]);
        
        // Verificar si el usuario ya votó este juego
        $userId = (int)$_SESSION["user_id"];
        $stmtVote = $conn->prepare("SELECT vote_type FROM game_votes WHERE user_id = :user_id AND game_id = :game_id LIMIT 1");
        $stmtVote->execute([':user_id' => $userId, ':game_id' => $id]);
        $userVote = $stmtVote->fetch(PDO::FETCH_ASSOC);
        
        $game['user_vote'] = $userVote ? (int)$userVote['vote_type'] : null;
    }
} catch (Exception $e) {
    $game = false;
}

if (!$game) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

require __DIR__ . DIRECTORY_SEPARATOR . "VerJuegophp.php";
