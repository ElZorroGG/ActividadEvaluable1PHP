<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <script>
function getVote(int) {
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("poll").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","poll_vote.php?vote="+int,true);
  xmlhttp.send();
}
</script>
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
        <p class="small"><?php echo htmlspecialchars($game["upvote"]." votos positivos ".htmlspecialchars($game["downvote"])." votos negativos"); ?></p>
        <div class="estadisticas-vj" style="margin:16px 0;padding:12px;background:linear-gradient(90deg, rgba(0,229,255,0.08), rgba(124,255,111,0.08));border-radius:8px;border:1px solid rgba(0,229,255,0.15);">
          <p class="small" style="margin:0;display:flex;align-items:center;gap:8px;">
            <strong style="color:var(--accent);">Visitas:</strong> 
            <span style="font-weight:700;font-size:16px;color:var(--accent);"><?php echo number_format((int)($game["visualizaciones"] ?? 0)); ?></span>
          </p>
        </div>
        <h3>Descripción</h3>
        <p><?php echo nl2br(htmlspecialchars($game["descripcion"])); ?></p>
        <?php if (!empty($game["url"])): ?>
          <p><a href="<?php echo htmlspecialchars($game["url"]); ?>" target="_blank">Sitio oficial</a></p>
        <?php endif; ?>
      </div>
      <h3>Recomendarias o no este juego?</h3>
      <form>
        Yes: <input type="radio" name="vote" value="0" onclick="getVote(this.value)"><br>
        No: <input type="radio" name="vote" value="1" onclick="getVote(this.value)">
      </form>
    </div>

    <div class="panel-footer-vj">
      <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php">Volver a la lista</a>
      <?php if ((int)($game["user_id"] ?? 0) === (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0)): ?>
        <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=<?php echo (int)$game["id"]; ?>">Editar</a>
        <form method="post" action="/ActividadEvaluable1PHP/BibliotecaDeJuegos/EliminarJuego.php" style="display:inline-block;margin:0;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este juego? Esta acción no se puede deshacer.');">
          <input type="hidden" name="id" value="<?php echo (int)$game["id"]; ?>">
          <button type="submit" class="button secondary" style="background:linear-gradient(90deg,var(--danger), #ff7a8b);color:#fff;border:none;">Eliminar</button>
        </form>
      <?php endif; ?>
      
    </div>
  </div>
</div>
</body>
</html>
