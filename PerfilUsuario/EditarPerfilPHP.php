<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}

require_once __DIR__ . '/../Conexion.php';

$error = "";
$userId = $_SESSION["user_id"] ?? 0;
$nombre = trim($_POST["nombre"] ?? "");
$contraseñaActual = $_POST["contraseñaActual"] ?? "";
$contraseñaNueva = $_POST["contraseñaNueva"] ?? "";
$confirmarContraseña = $_POST["confirmarContraseña"] ?? "";

$carpetaFotoPerfil = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "FotoPerfil";
if (!is_dir($carpetaFotoPerfil)) {
    mkdir($carpetaFotoPerfil, 0755, true);
}

if ($nombre === "") {
    $error .= "El nombre no puede estar vacío. ";
}

if (!empty($contraseñaNueva) && $contraseñaActual === "") {
    $error .= "Debes ingresar tu contraseña actual para cambiar la contraseña. ";
}

if ($error === "" && !empty($contraseñaNueva)) {
    try {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([":id" => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($contraseñaActual, $user["password"])) {
            $error .= "La contraseña actual es incorrecta. ";
        }
    } catch (PDOException $e) {
        $error .= "Error al verificar la contraseña. ";
    }
}

$cambiarContraseña = false;
$hashNuevo = null;

if ($error === "" && !empty($contraseñaNueva)) {
    if ($contraseñaNueva !== $confirmarContraseña) {
        $error .= "Las contraseñas nuevas no coinciden. ";
    } else {
        $minLen = 8;
        $needs = [];
        if (mb_strlen($contraseñaNueva) < $minLen) $needs[] = "al menos $minLen caracteres";
        if (!preg_match('/[A-Z]/', $contraseñaNueva)) $needs[] = "una mayúscula";
        if (!preg_match('/[a-z]/', $contraseñaNueva)) $needs[] = "una minúscula";
        if (!preg_match('/[0-9]/', $contraseñaNueva)) $needs[] = "un número";
        if (!preg_match('/[\W_]/', $contraseñaNueva)) $needs[] = "un carácter especial";
        
        if (!empty($needs)) {
            $error .= "La contraseña nueva debe contener: " . implode(', ', $needs) . ". ";
        } else {
            $cambiarContraseña = true;
            $hashNuevo = password_hash($contraseñaNueva, PASSWORD_DEFAULT);
        }
    }
}

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
                $rutaFotoPerfil = "FotoPerfil/" . $nuevoNombre;
            } else {
                $error .= "No se pudo guardar la foto de perfil. ";
            }
        }
    }
}

if ($error !== "") {
    $_SESSION["ErrorEditarPerfil"] = $error;
    header("Location: /ActividadEvaluable1PHP/PerfilUsuario/EditarPerfil.php");
    exit;
}

try {
    if ($cambiarContraseña && $rutaFotoPerfil) {
        $stmt = $conn->prepare("UPDATE users SET Nombre = :nombre, password = :password, foto_perfil = :foto WHERE id = :id");
        $stmt->execute([
            ":nombre" => $nombre,
            ":password" => $hashNuevo,
            ":foto" => $rutaFotoPerfil,
            ":id" => $userId
        ]);
    } elseif ($cambiarContraseña) {
        $stmt = $conn->prepare("UPDATE users SET Nombre = :nombre, password = :password WHERE id = :id");
        $stmt->execute([
            ":nombre" => $nombre,
            ":password" => $hashNuevo,
            ":id" => $userId
        ]);
    } elseif ($rutaFotoPerfil) {
        $stmt = $conn->prepare("UPDATE users SET Nombre = :nombre, foto_perfil = :foto WHERE id = :id");
        $stmt->execute([
            ":nombre" => $nombre,
            ":foto" => $rutaFotoPerfil,
            ":id" => $userId
        ]);
    } else {
        $stmt = $conn->prepare("UPDATE users SET Nombre = :nombre WHERE id = :id");
        $stmt->execute([
            ":nombre" => $nombre,
            ":id" => $userId
        ]);
    }
    
    $_SESSION["Usuario"] = $nombre;
    $_SESSION["ExitoEditarPerfil"] = "Perfil actualizado correctamente.";
    header("Location: /ActividadEvaluable1PHP/PerfilUsuario/EditarPerfil.php");
    exit;

} catch (PDOException $e) {
    $_SESSION["ErrorEditarPerfil"] = "Error al actualizar el perfil: " . $e->getMessage();
    header("Location: /ActividadEvaluable1PHP/PerfilUsuario/EditarPerfil.php");
    exit;
}
