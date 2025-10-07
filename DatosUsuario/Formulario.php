<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require __DIR__ . '/../Conexion.php';
//Datos recogidos en el registro
$error = "";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$pass = $_POST["contraseña"] ?? "";
$pass2 = $_POST["CorfirmaContraseña"] ?? "";
    //Requisitos de seguridad para que el usuario no la cague
if ($nombre === "") {
    $error .= "Nombre vacío. ";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error .= "Mail no válido. ";
}

if ($pass === "" || $pass2 === "") {
    $error .= "Contraseña vacía. ";
} elseif ($pass !== $pass2) {
    $error .= "Contraseñas no coinciden. ";
} else {
    //Requisitos de seguridad que considero necesarios
    $minLen = 8;
    $needs = [];
    if (mb_strlen($pass) < $minLen) $needs[] = "al menos $minLen caracteres";
    if (!preg_match('/[A-Z]/', $pass)) $needs[] = "una mayúscula";
    if (!preg_match('/[a-z]/', $pass)) $needs[] = "una minúscula";
    if (!preg_match('/[0-9]/', $pass)) $needs[] = "un número";
    if (!preg_match('/[\W_]/', $pass)) $needs[] = "un carácter especial";
    if (!empty($needs)) {
        $error .= "La contraseña debe contener: " . implode(', ', $needs) . ". ";
    }
}

//Comprueba que el mail no exista todavia
if ($error === "") {
    try {
        $check = $conn->prepare("SELECT id FROM users WHERE mail = :mail LIMIT 1");
        $check->bindValue(":mail", $email);
        $check->execute();
        $exists = $check->fetch(PDO::FETCH_ASSOC);
        if ($exists) {
            $error .= "Ya existe una cuenta con ese mail. Si es tuya, inicia sesión. ";
        }
    } catch (PDOException $e) {

        $error .= "Error al verificar el mail. Intenta de nuevo. ";
    }
}
//Si hay un error con variables de session redirige de nuevo al registro rellenando los campos importantes de el registro
if ($error !== "") {
    $_SESSION["Error"] = $error;
    $_SESSION["nombre"] = $nombre;
    $_SESSION["mail"] = $email;
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/Registro.php");
    exit;
}
//Si todo va bien ejecuta el try y se conecta a la base de datos creando el usuario y encriptando la contraseña
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
    