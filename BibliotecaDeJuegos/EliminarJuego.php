<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}

require_once __DIR__ . '/../Conexion.php';

$id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

if ($id <= 0) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT user_id, caratula FROM bibliotecajuegos WHERE id = :id LIMIT 1");
    $stmt->execute([":id" => $id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$game) {
        header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
        exit;
    }

    if ((int)$game["user_id"] !== (int)$_SESSION["user_id"]) {
        header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
        exit;
    }

    if (!empty($game["caratula"]) && strpos($game["caratula"], "CaratulaPorDefecto") === false) {
        $caratulaPath = __DIR__ . "/../" . ltrim($game["caratula"], "/\\");
        if (file_exists($caratulaPath)) {
            @unlink($caratulaPath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM bibliotecajuegos WHERE id = :id");
    $stmt->execute([":id" => $id]);

    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php?deleted=1");
    exit;

} catch (Exception $e) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php?error=1");
    exit;
}
