<?php
session_start();
require('Conexion.php');

if (!isset($_SESSION['Usuario'])) {
    header('Location: login.php');
    die;
}
$user_id=$_SESSION["id_Usuario"] ?? null;

$tituloJuego=$_POST["NombreJuego"] ?? null;
$descripcion = $_POST['Descripcion'] ?? null;
$autor = $_POST['Autor'] ?? null;
$categoria = $_POST['Categoria'] ?? null;
$url = $_POST['url'] ?? null;
$fecha = $_POST['fecha'] ?? null;

if (!$titulo) {
    $_SESSION['ErrorAddGame'] = 'El título es obligatorio.';
    header('Location: add_game.php');
    exit;
}
$tituloJuego = trim(strip_tags($titulo));
$descripcion = trim(strip_tags($descripcion));
$autor = trim(strip_tags($autor));
$categoria = trim(strip_tags($categoria));
$url = filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
$fecha = is_numeric($anio) ? (int)$anio : null;

if ($file['size'] > 5 * 1024 * 1024) {
        $_SESSION['ErrorAddGame'] = 'La imagen es demasiado grande (max 5MB).';
        header('Location: add_game.php');
        exit;
    }
