<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($game['titulo']); ?></title>
  <link rel="stylesheet" href="Estilo.css">
</head>
<body>
<?php include 'menu.php'; ?>

<div class="container">
  <div class="panel">
    <div class="game-detail">
      <div class="cover-large">
        <img src="<?php echo htmlspecialchars($game['caratula'] ?: 'CaratulaPorDefecto/default.jpg'); ?>" alt="<?php echo htmlspecialchars($game['titulo']); ?>" style="width:100%;height:auto;border-radius:8px">
      </div>
      <div class="details" style="margin-top:12px">
        <h1><?php echo htmlspecialchars($game['titulo']); ?></h1>
        <p class="small">Autor / Estudio: <?php echo htmlspecialchars($game['autor']); ?></p>
        <p class="small">Categoría: <?php echo htmlspecialchars($game['categoria']); ?></p>
        <p class="small">Año: <?php echo htmlspecialchars($game['anio']); ?></p>
        <h3>Descripción</h3>
        <p><?php echo nl2br(htmlspecialchars($game['descripcion'])); ?></p>
        <?php if (!empty($game['url'])): ?>
          <p><a href="<?php echo htmlspecialchars($game['url']); ?>" target="_blank">Sitio oficial</a></p>
        <?php endif; ?>
      </div>
    </div>

    <div style="margin-top:12px">
      <a class="button" href="VerJuegos.php">Volver a la lista</a>
      <?php if ((int)($game['user_id'] ?? 0) === (int)($_SESSION['user_id'] ?? $_SESSION['id'] ?? 0)): ?>
        <a class="button" href="VerJuegoEditar.php?id=<?php echo (int)$game['id']; ?>">Editar</a>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
