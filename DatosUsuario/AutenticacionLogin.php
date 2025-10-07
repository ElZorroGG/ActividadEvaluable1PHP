<?php
//Codigo php del login
//Si la sesion no esta iniciada la inicia
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require __DIR__ . '/../Conexion.php';

$passwordInput = null;
if (isset($_POST["contrasena"])) {
    $passwordInput = $_POST["contrasena"];
};
//Comprueba que la contraseña este introducida
if (!isset($_POST["nombre"]) || $passwordInput === null) {
    $_SESSION["ErrorLogin"] = "Introduce nombre y contraseña.";
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}
//Elimina los espacion en blanco del nombre por si acaso tiene 2
$nombre = trim($_POST["nombre"]);
$contrasena = $passwordInput;
//Conexion para verificar le login y si funciona entras y si no a casa con error
try {
    $stmt = $conn->prepare("SELECT id, Nombre, password, mail FROM users WHERE Nombre = :nombre LIMIT 1");
    $stmt->bindParam(":nombre", $nombre);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user["password"])) {

        $_SESSION["Log"] = $user["mail"];
        $_SESSION["Usuario"] = $user["Nombre"];
        $_SESSION["user_id"] = $user["id"];
    header("Location: /ActividadEvaluable1PHP/Session.php");
        exit;
    } else {
        $_SESSION["ErrorLogin"] = "Nombre o contraseña incorrectos.";
        $_SESSION["nombre_login"] = $nombre;
        header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
        exit;
    }
} catch (PDOException $e) {

    $_SESSION["ErrorLogin"] = "Error de conexión: " . $e->getMessage();
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}


?>