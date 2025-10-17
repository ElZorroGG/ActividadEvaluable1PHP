<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../Conexion.php';

$error = "";
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$pass = $_POST["contraseña"] ?? "";
$pass2 = $_POST["CorfirmaContraseña"] ?? "";

$carpetaFotoPerfil = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "FotoPerfil";
if (!is_dir($carpetaFotoPerfil)) {
    mkdir($carpetaFotoPerfil, 0755, true);
}

$carpetaDefecto = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PerfilPorDefecto";
if (!is_dir($carpetaDefecto)) {
    mkdir($carpetaDefecto, 0755, true);
}

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
$rutaFotoPerfil = null;

if ($error === "" && isset($_FILES["fotoPerfil"]) && $_FILES["fotoPerfil"]["error"] == UPLOAD_ERR_OK) {
    $temporal = $_FILES["fotoPerfil"]["tmp_name"];
    $size = $_FILES["fotoPerfil"]["size"];
    $name = $_FILES["fotoPerfil"]["name"];

    if ($size > 5 * 1024 * 1024) {
        $error .= "La foto de perfil es demasiado grande (max 5MB). ";
    } else {
        $partes = explode(".", $name);
        $ext = strtolower(end($partes));
        $permitidas = array("jpg", "jpeg", "png", "gif", "webp");
        
        if (!in_array($ext, $permitidas)) {
            $error .= "Tipo de imagen no permitido. Usa JPG, PNG, GIF o WEBP. ";
        } else {
            $contenido = file_get_contents($temporal);
            $hash = hash("sha256", $contenido);
            $nuevoNombre = $hash . "." . $ext;
            $destino = $carpetaFotoPerfil . DIRECTORY_SEPARATOR . $nuevoNombre;

            $intentos = 0;
            while (file_exists($destino) && $intentos < 5) {
                $sufijo = substr(bin2hex(random_bytes(4)), 0, 6);
                $nuevoNombre = $hash . "_" . $sufijo . "." . $ext;
                $destino = $carpetaFotoPerfil . DIRECTORY_SEPARATOR . $nuevoNombre;
                $intentos++;
            }

            if (move_uploaded_file($temporal, $destino)) {
                $rutaFotoPerfil = 'FotoPerfil/' . $nuevoNombre;
            } else {
                $error .= "No se pudo guardar la foto de perfil. ";
            }
        }
    }
}

if ($rutaFotoPerfil === null) {
    $archivosDef = glob($carpetaDefecto . DIRECTORY_SEPARATOR . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    if (!empty($archivosDef)) {
        $rutaFotoPerfil = 'PerfilPorDefecto/' . basename($archivosDef[0]);
    } else {
        $rutaFotoPerfil = '/ActividadEvaluable1PHP/PerfilPorDefecto/default.png';
    }
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
    $stmt = $conn->prepare("INSERT INTO users (Nombre, password, mail, foto_perfil) VALUES (:nombre, :password, :mail, :foto_perfil)");
    $stmt->bindValue(":nombre", $nombre);
    $stmt->bindValue(":password", $hash);
    $stmt->bindValue(":mail", $email);
    $stmt->bindValue(":foto_perfil", $rutaFotoPerfil);
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
    