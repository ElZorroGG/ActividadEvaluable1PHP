<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require __DIR__ . '/../Conexion.php';

$error = "";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$pass = $_POST["contraseña"] ?? "";
$pass2 = $_POST["CorfirmaContraseña"] ?? "";

if ($nombre === "") {
    $error .= "Nombre vacío. ";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error .= "Mail no válido. ";
}
if ($pass === "" || $pass !== $pass2) {
    $error .= "Contraseñas no coinciden. ";
}

if ($error !== "") {
    $_SESSION["Error"] = $error;
    $_SESSION["nombre"] = $nombre;
    $_SESSION["mail"] = $email;
        header("Location: /ActividadEvaluable1PHP/DatosUsuario/Registro.php");
    exit;
}

try {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (Nombre, password, mail) VALUES (:nombre, :password, :mail)");
    $stmt->bindValue(":nombre", $nombre);
    $stmt->bindValue(":password", $hash);
    $stmt->bindValue(":mail", $email);
    $stmt->execute();

    $_SESSION["Log"] = $email;
    $_SESSION["Usuario"] = $nombre;
    $_SESSION["user_id"] = $conn->lastInsertId();
    header("Location: /ActividadEvaluable1PHP/Session.php");
    exit;
} catch (PDOException $e) {
    $_SESSION["Error"] = "Error al crear usuario: " . $e->getMessage();
    $_SESSION["nombre"] = $nombre;
    $_SESSION["mail"] = $email;
        header("Location: /ActividadEvaluable1PHP/DatosUsuario/Registro.php");
    exit;
}
    