<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}

require_once __DIR__ . '/../Conexion.php';

$error = $_SESSION["ErrorEditarPerfil"] ?? "";
$exito = $_SESSION["ExitoEditarPerfil"] ?? "";
unset($_SESSION["ErrorEditarPerfil"], $_SESSION["ExitoEditarPerfil"]);

$userId = $_SESSION["user_id"] ?? 0;

try {
    $stmt = $conn->prepare("SELECT Nombre, foto_perfil FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header("Location: /ActividadEvaluable1PHP/Session.php");
        exit;
    }
} catch (PDOException $e) {
    $error = "Error al cargar los datos del usuario.";
    $user = ['Nombre' => '', 'foto_perfil' => ''];
}

$fotoPerfil = '/ActividadEvaluable1PHP/PerfilPorDefecto/Perfil.webp';
$fotoPerfilTemp = $user['foto_perfil'] ?? '';
if (!empty($fotoPerfilTemp) && $fotoPerfilTemp !== '') {
    if (strpos($fotoPerfilTemp, '/') !== 0) {
        $fotoPerfil = '/ActividadEvaluable1PHP/' . $fotoPerfilTemp;
    } else {
        $fotoPerfil = $fotoPerfilTemp;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css?v=3">
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-foto');
            const previewContainer = document.getElementById('preview-container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'flex';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>

<div class="container">
    <div class="panel">
        <h1>Editar Perfil</h1>
        
        <?php if ($error): ?>
            <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($exito): ?>
            <div class="notice success"><?php echo htmlspecialchars($exito); ?></div>
        <?php endif; ?>

        <form action="/ActividadEvaluable1PHP/PerfilUsuario/EditarPerfilPHP.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <label for="nombre">Nombre de usuario</label>
                <input name="nombre" id="nombre" type="text" value="<?php echo htmlspecialchars($user['Nombre'] ?? ''); ?>" required>
            </div>

            <div class="form-row">
                <label for="contraseñaActual">Contraseña actual (solo si cambias la contraseña)</label>
                <input name="contraseñaActual" id="contraseñaActual" type="password" placeholder="Ingresa tu contraseña actual">
            </div>

            <div class="form-row">
                <label for="contraseñaNueva">Nueva contraseña (opcional)</label>
                <input name="contraseñaNueva" id="contraseñaNueva" type="password" placeholder="Dejar vacío para no cambiar">
            </div>

            <div class="form-row">
                <label for="confirmarContraseña">Confirmar nueva contraseña</label>
                <input name="confirmarContraseña" id="confirmarContraseña" type="password" placeholder="Confirmar nueva contraseña">
            </div>

            <div class="foto-perfil-container">
                <h3 style="margin-bottom: 10px;">Foto de perfil actual</h3>
                <img src="<?php echo htmlspecialchars((string)$fotoPerfil); ?>" alt="Foto actual" class="preview-foto">
                
                <div class="upload-box" onclick="document.getElementById('fotoPerfil').click()">
                    <label for="fotoPerfil">Cambiar foto de perfil</label>
                    <small>Haz clic para seleccionar una nueva imagen<br>Máximo 5MB · JPG, PNG, GIF, WEBP</small>
                    <input name="fotoPerfil" id="fotoPerfil" type="file" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewImage(this)">
                </div>
                
                <div id="preview-container" class="preview-container">
                    <img id="preview-foto" class="preview-foto" src="" alt="Vista previa">
                    <small>Nueva foto de perfil</small>
                </div>
            </div>

            <div class="actions">
                <button type="submit">Guardar cambios</button>
                <a class="menu-btn" href="/ActividadEvaluable1PHP/Session.php">Cancelar</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
