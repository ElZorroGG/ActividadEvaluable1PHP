<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ver Juegos</title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>
<div class="container">
  <div class="panel">
    <h1>Juegos</h1>
    <div x-data="{tab: 'todos'}" style="margin-top:12px">
      <div class="menu" style="margin-bottom:8px;">
          <div class="menu-inner" style="padding:8px">
          <div class="menu-list">
            <a href="#" :class='{"active-tab": tab==="todos"}' @click.prevent='tab="todos"'>Todos</a>
            <a href="#" :class='{"active-tab": tab==="mios"}' @click.prevent='tab="mios"'>Mis juegos</a>
          </div>
        </div>
      </div>

      <div x-show="tab==='todos'">
        <div class="grid-games">
          <?php foreach (($games["todos"] ?? []) as $j):
            $img = $j["caratula"] ?: "CaratulaPorDefecto/default.jpg";
            if (!preg_match('#^(https?:)?//#', $img) && strpos($img, '/') !== 0) {
                $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
            }
            $title = htmlspecialchars($j["titulo"]);
            $autor = htmlspecialchars($j["autor"]);
          ?>
          <?php $bg = htmlspecialchars($img); ?>
          <a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$j["id"]; ?>" style="--bg-url: url('<?php echo $bg; ?>');">
            <div class="meta-overlay">
              <div class="meta">
                <div class="title"><?php echo $title; ?></div>
                <div class="author small"><?php echo $autor; ?></div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div x-show="tab==='mios'" x-cloak>
        <div class="grid-games">
          <?php foreach (($games["mios"] ?? []) as $j):
            $img = $j["caratula"] ?: "CaratulaPorDefecto/default.jpg";
            if (!preg_match('#^(https?:)?//#', $img) && strpos($img, '/') !== 0) {
                $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
            }
            $title = htmlspecialchars($j["titulo"]);
            $autor = htmlspecialchars($j["autor"]);
          ?>
          <?php $bg = htmlspecialchars($img); ?>
          <a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$j["id"]; ?>" style="--bg-url: url('<?php echo $bg; ?>');">
            <div class="meta-overlay">
              <div class="meta">
                <div class="title"><?php echo $title; ?></div>
                <div class="author small"><?php echo $autor; ?></div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
