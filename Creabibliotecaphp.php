<?php

session_start();
require("Conexion.php");


if (empty($_SESSION["Usuario"]) || (empty($_SESSION["user_id"]) && empty($_SESSION["id"]))) {
    $_SESSION["ErrorAñadirJuego"] = "Debes iniciar sesión para añadir un juego.";
    header("Location: login.php");
    exit;
}

$idUsuario = isset($_SESSION["user_id"]) ? (int) $_SESSION["user_id"] : (int) ($_SESSION["id"] ?? 0);


$titulo = isset($_POST["Titulo"]) ? trim($_POST["Titulo"]) : "";
$descripcion = isset($_POST["Descripcion"]) ? trim($_POST["Descripcion"]) : "";
$autor = isset($_POST["Autor"]) ? trim($_POST["Autor"]) : "";
$categoria = isset($_POST["Categoria"]) ? trim($_POST["Categoria"]) : "";
$url = isset($_POST["Url"]) ? trim($_POST["Url"]) : "";
$fecha = isset($_POST["Fecha"]) ? (int)$_POST["Fecha"] : null;


if ($titulo === "") {
    $_SESSION["ErrorAñadirJuego"] = "El título es obligatorio.";
    header("Location: CreaBiblioteca.php");
    exit;
}


$rutaPortada = null;
$carpetaSubidas = __DIR__ . DIRECTORY_SEPARATOR . "caratulas";
if (!is_dir($carpetaSubidas)) {
    mkdir($carpetaSubidas, 0755);
}

$carpetaDefecto = __DIR__ . DIRECTORY_SEPARATOR . "CaratulaPorDefecto";
if (!is_dir($carpetaDefecto)) {
    mkdir($carpetaDefecto, 0755);
}

if (isset($_FILES["Portada"]) && $_FILES["Portada"]["error"] == UPLOAD_ERR_OK) {
    $temporal = $_FILES["Portada"]["tmp_name"];
    $size = $_FILES["Portada"]["size"];
    $name = $_FILES["Portada"]["name"];

    if ($size > 5 * 1024 * 1024) {
        $_SESSION["ErrorAñadirJuego"] = "La imagen es demasiado grande (max 5MB).";
        header("Location: CreaBiblioteca.php");
        exit;
    }


    $partes = explode(".", $name);
    $ext = strtolower(end($partes));
    $permitidas = array("jpg", "jpeg", "png", "gif", "webp");
    if (!in_array($ext, $permitidas)) {
        $_SESSION["ErrorAñadirJuego"] = "Tipo de imagen no permitido. Usa JPG, PNG, GIF o WEBP.";
        header("Location: CreaBiblioteca.php");
        exit;
    }


    $contenido = file_get_contents($temporal);
    $hash = hash("sha256", $contenido);
    $nuevoNombre = $hash . "." . $ext;
    $destino = $carpetaSubidas . DIRECTORY_SEPARATOR . $nuevoNombre;

    $intentos = 0;
    while (file_exists($destino) && $intentos < 5) {
        $sufijo = substr(bin2hex(random_bytes(4)), 0, 6);
        $nuevoNombre = $hash . "_" . $sufijo . "." . $ext;
        $destino = $carpetaSubidas . DIRECTORY_SEPARATOR . $nuevoNombre;
        $intentos++;
    }

    if (move_uploaded_file($temporal, $destino)) {
           $rutaPortada = "caratulas/" . $nuevoNombre; 
    } else {
        $_SESSION["ErrorAñadirJuego"] = "No se pudo guardar la imagen.";
        header("Location: CreaBiblioteca.php");
        exit;
    }
}

if ($rutaPortada === null) {
    $archivosDef = glob($carpetaDefecto . DIRECTORY_SEPARATOR . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
    if (!empty($archivosDef)) {
        $nombreDef = basename($archivosDef[0]);
        $rutaPortada = "CaratulaPorDefecto/" . $nombreDef;
    } else {
        $rutaPortada = null;
    }
}

if ($url !== "") {
    $esValida = filter_var($url, FILTER_VALIDATE_URL) !== false;
    $scheme = strtolower(parse_url($url, PHP_URL_SCHEME) ?? "");
    if (!$esValida || !in_array($scheme, ["http", "https"])) {
        $_SESSION["ErrorAñadirJuego"] = "La URL no tiene un formato válido. Usa http:// o https://";
        header("Location: CreaBiblioteca.php");
        exit;
    }
}

try {
    $sql = "INSERT INTO bibliotecajuegos (user_id, titulo, descripcion, autor, caratula, categoria, url, anio) VALUES (:user_id, :titulo, :descripcion, :autor, :caratula, :categoria, :url, :anio)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":user_id", $idUsuario);
    $stmt->bindValue(":titulo", $titulo);
    $stmt->bindValue(":descripcion", $descripcion);
    $stmt->bindValue(":autor", $autor);
    $stmt->bindValue(":caratula", $rutaPortada);
    $stmt->bindValue(":categoria", $categoria);
    $stmt->bindValue(":url", $url);
    $stmt->bindValue(":anio", $fecha);
    $stmt->execute();
    $_SESSION["ExitoAñadirJuego"] = "Juego añadido correctamente.";
} catch (Exception $e) {
    $_SESSION["ErrorAñadirJuego"] = "Error al guardar el juego: " . $e->getMessage();
}

header("Location: CreaBiblioteca.php");
exit;
