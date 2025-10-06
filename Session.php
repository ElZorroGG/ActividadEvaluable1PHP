<?php
session_start();
if (!isset($_SESSION["Usuario"])) {
    header("Location: login.php");
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
<?php include "menu.php"; ?>

<div class="container">
    <div class="panel">
        <h1 style="text-align:center">Bienvenido <?php echo htmlspecialchars($_SESSION["Usuario"]); ?></h1>
                <p class="small" style="text-align:center">Desde aquí puedes crear un juego o ver la lista completa.</p>
                <div class="menu" style="margin-top:16px;display:flex;justify-content:center">
                    <div class="menu-inner" style="padding:6px 8px">
                        <div class="menu-list">
                            <a href="CreaBiblioteca.php">Crear juego</a>
                            <a href="VerJuegos.php">Ver juegos</a>
                        </div>
                    </div>
                </div>
    </div>
</div>
</body>
</html>
