<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../Conexion.php';

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
        
        if (isset($_POST["recordar"]) && $_POST["recordar"] == "1") {
            $token = bin2hex(random_bytes(32));
            $expiry = time() + (1 * 60);
            
            setcookie("remember_token", $token, $expiry, "/", "", false, true);
            setcookie("remember_user", $user["id"], $expiry, "/", "", false, true);
            
            $stmt = $conn->prepare("UPDATE users SET remember_token = :token, remember_expiry = :expiry WHERE id = :id");
            $stmt->execute([
                ":token" => hash("sha256", $token),
                ":expiry" => date("Y-m-d H:i:s", $expiry),
                ":id" => $user["id"]
            ]);
        }
        
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