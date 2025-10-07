<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/login.php");
    exit;
}
require_once __DIR__ . '/../Conexion.php';

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE id = :id LIMIT 1");
    $stmt->execute([
        ":id" => $id
    ]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $game = false;
}

if (!$game) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

$ownerId = (int)($game["user_id"] ?? 0);
$currentUser = (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0);
if ($ownerId !== $currentUser) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["Titulo"] ?? "");
    $descripcion = trim($_POST["Descripcion"] ?? "");
    $autor = trim($_POST["Autor"] ?? "");
    $categoria = trim($_POST["Categoria"] ?? "");
    $url = trim($_POST["Url"] ?? "");
    $anio = isset($_POST["Fecha"]) ? (int)$_POST["Fecha"] : null;

    if ($titulo === "") {
           $_SESSION["ErrorEditar"] = "El título es obligatorio.";
        header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
        exit;
    }

        if ($url !== "") {
        $esValida = filter_var($url, FILTER_VALIDATE_URL) !== false;
        $scheme = strtolower(parse_url($url, PHP_URL_SCHEME) ?? "");
        if (!$esValida || !in_array($scheme, ["http", "https"])) {
                $_SESSION["ErrorEditar"] = "La URL no tiene un formato válido. Usa http:// o https://";
            header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
            exit;
        }
    }

    $rutaPortada = $game["caratula"];
    $carpetaSubidas = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "caratulas";
    if (!is_dir($carpetaSubidas)) mkdir($carpetaSubidas, 0755);

    if (isset($_FILES["Portada"]) && $_FILES["Portada"]["error"] == UPLOAD_ERR_OK) {
        $temporal = $_FILES["Portada"]["tmp_name"];
        $name = $_FILES["Portada"]["name"];
        $size = $_FILES["Portada"]["size"];
        if ($size > 5 * 1024 * 1024) {
              $_SESSION["ErrorEditar"] = "Imagen demasiado grande (max 5MB).";
            header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
            exit;
        }
        $partes = explode(".", $name);
        $ext = strtolower(end($partes));
        $permitidas = ["jpg","jpeg","png","gif","webp"];
        if (!in_array($ext, $permitidas)) {
              $_SESSION["ErrorEditar"] = "Tipo de imagen no permitido.";
            header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
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
            $rutaPortada = '/ActividadEvaluable1PHP/caratulas/' . $nuevoNombre;
        } else {
            $_SESSION["ErrorEditar"] = "No se pudo guardar la imagen.";
            header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
            exit;
        }
    }

    try {
        $sql = "UPDATE bibliotecajuegos SET titulo = :titulo, descripcion = :descripcion, autor = :autor, caratula = :caratula, categoria = :categoria, url = :url, anio = :anio WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":titulo" => $titulo,
            ":descripcion" => $descripcion,
            ":autor" => $autor,
            ":caratula" => $rutaPortada,
            ":categoria" => $categoria,
            ":url" => $url,
            ":anio" => $anio,
            ":id" => $id
        ]);
        $_SESSION["ExitoEditar"] = "Juego actualizado correctamente.";
        header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=" . $id);
        exit;
    } catch (Exception $e) {
            $_SESSION["ErrorEditar"] = "Error al actualizar: " . $e->getMessage();
        header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=" . $id);
        exit;
    }
}

require __DIR__ . '/VerJuegoEditar.php';
