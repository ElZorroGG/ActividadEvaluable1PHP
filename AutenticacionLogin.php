<?php
session_start();
require("Conexion.php");

$passwordInput = null;
if (isset($_POST["contrasena"])) {
    $passwordInput = $_POST["contrasena"];
} elseif (isset($_POST["contraseña"])) {
    $passwordInput = $_POST["contraseña"];
}

if (!isset($_POST["nombre"]) || $passwordInput === null) {
    $_SESSION["ErrorLogin"] = "Introduce nombre y contraseña.";
    header("Location: login.php");
    exit;
}

$nombre = trim($_POST["nombre"]);
$contrasena = $passwordInput;

try {
    $stmt = $conn->prepare("SELECT id, Nombre, password, mail FROM users WHERE Nombre = :nombre LIMIT 1");
    $stmt->bindParam(":nombre", $nombre);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user["password"])) {

        $_SESSION["Log"] = $user["mail"];
        $_SESSION["Usuario"] = $user["Nombre"];
        $_SESSION["user_id"] = $user["id"];
        header("Location: Session.php");
        exit;
    } else {
        $_SESSION["ErrorLogin"] = "Nombre o contraseña incorrectos.";
        $_SESSION["nombre_login"] = $nombre;
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {

    $_SESSION["ErrorLogin"] = "Error de conexión: " . $e->getMessage();
    header("Location: login.php");
    exit;
}


?>
p´ñ