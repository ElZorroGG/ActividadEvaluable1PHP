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
</head>
<body>
    <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['Usuario']); ?></h1>
    <p><a href="add_game.php">Añadir un juego</a></p>

    <form action="cerrarSession.php" method="post" style="display:inline">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
