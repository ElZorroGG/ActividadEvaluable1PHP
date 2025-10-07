<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($game["titulo"]); ?></title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.css">
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>

<div class="container">
  <div class="panel">
    <div class="game-detail-vj">
      <h1 class="title-vj"><?php echo htmlspecialchars($game["titulo"]); ?></h1>
      <div class="cover-vj">
        <?php
        $caratula = $game["caratula"] ?: 'CaratulaPorDefecto/default.jpg';
        // Si no es ruta absoluta, convertirla a absoluta dentro del proyecto
        if (!preg_match('#^(https?:)?//#', $caratula) && strpos($caratula, '/') !== 0) {
            $caratula = '/ActividadEvaluable1PHP/' . ltrim($caratula, '/\\');
        }
        ?>
        <img src="<?php echo htmlspecialchars($caratula); ?>" alt="<?php echo htmlspecialchars($game["titulo"]); ?>">
      </div>
      <div class="details-vj" style="margin-top:12px">
        <p class="small">Autor / Estudio: <?php echo htmlspecialchars($game["autor"]); ?></p>
        <p class="small">Categoría: <?php echo htmlspecialchars($game["categoria"]); ?></p>
        <p class="small">Año: <?php echo htmlspecialchars($game["anio"]); ?></p>
        <h3>Descripción</h3>
        <p><?php echo nl2br(htmlspecialchars($game["descripcion"])); ?></p>
        <?php if (!empty($game["url"])): ?>
          <p><a href="<?php echo htmlspecialchars($game["url"]); ?>" target="_blank">Sitio oficial</a></p>
        <?php endif; ?>
      </div>
    </div>

    <div class="panel-footer-vj">
      <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php">Volver a la lista</a>
      <?php if ((int)($game["user_id"] ?? 0) === (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0)): ?>
        <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=<?php echo (int)$game["id"]; ?>">Editar</a>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
