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
    <title>Panel</title>
    <link rel="stylesheet" href="Estilo.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    </head>
<body>
<?php include 'menu.php'; ?>

<div class="container">
    <div class="panel">
        <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['Usuario']); ?></h1>
        <p class="small">Desde aquí puedes crear un juego o ver la lista completa.</p>
        <div class="actions" style="margin-top:16px">
            <a class="button" href="CreaBiblioteca.php">Crear juego</a>
            <a class="button secondary" href="VerJuegos.php">Ver juegos</a>
        </div>
    </div>
</div>
</body>
</html>
