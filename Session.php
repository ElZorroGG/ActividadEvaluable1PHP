<?php
session_start();
if (!isset($_SESSION['Usuario'])) {
        header('Location: login.php');
        exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="utf-8">
        <title>Sesión</title>
        <link rel="stylesheet" href="Estilo.css">
        <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <div class="container">
        <div class="panel">
            <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['Usuario']); ?></h1>
            <p class="small">Gestiona tu biblioteca de juegos desde aquí.</p>
            <div class="actions">
                <a class="button" href="CreaBiblioteca.php">Añadir un juego</a>
                <form action="cerrarSession.php" method="post" style="display:inline">
                        <button type="submit" class="button secondary">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
