<?php
require_once __DIR__ . '/verificarSesion.php';

if (!verificarSesion()) {
    header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel</title>
    <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css?v=3">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php include __DIR__ . '/menu.php'; ?>

<div class="container">
    <div class="panel">
        <h1 style="text-align:center">Bienvenido <?php echo htmlspecialchars($_SESSION["Usuario"]); ?></h1>
        <p class="small" style="text-align:center">Desde aquí puedes crear un juego o ver la lista completa.</p>
        <div style="margin-top:24px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/CreaBiblioteca.php" class="menu-btn">Crear juego</a>
            <a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php" class="menu-btn">Ver juegos</a>
        </div>
    </div>
</div>
</body>
</html>