<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ver Juegos</title>
  <link rel="stylesheet" href="Estilo.css">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<?php include "menu.php"; ?>

<div class="container">
  <div class="panel">
    <h1>Juegos</h1>
    <div x-data="{tab: 'todos'}" style="margin-top:12px">
      <div class="menu" style="margin-bottom:8px;">
        <div class="menu-inner" style="padding:8px">
          <div class="brand">Ver juegos</div>
          <div class="menu-list">
            <a href="#" :class='{"active-tab": tab==="todos"}' @click.prevent='tab="todos"'>Todos</a>
            <a href="#" :class='{"active-tab": tab==="mios"}' @click.prevent='tab="mios"'>Mis juegos</a>
          </div>
        </div>
      </div>

      <div x-show="tab==='todos'">
        <div class="grid-games">
          <?php foreach (($games["todos"] ?? []) as $j):
            $img = htmlspecialchars($j["caratula"] ?: "CaratulaPorDefecto/default.jpg");
            $title = htmlspecialchars($j["titulo"]);
            $autor = htmlspecialchars($j["autor"]);
          ?>
          <a class="game-card" href="VerJuego.php?id=<?php echo (int)$j["id"]; ?>">
            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" class="cover" loading="lazy">
            <div class="meta">
              <div class="title"><?php echo $title; ?></div>
              <div class="author small"><?php echo $autor; ?></div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div x-show="tab==='mios'" x-cloak>
        <div class="grid-games">
          <?php foreach (($games["mios"] ?? []) as $j):
            $img = htmlspecialchars($j["caratula"] ?: "CaratulaPorDefecto/default.jpg");
            $title = htmlspecialchars($j["titulo"]);
            $autor = htmlspecialchars($j["autor"]);
          ?>
          <a class="game-card" href="VerJuego.php?id=<?php echo (int)$j["id"]; ?>">
            <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" class="cover" loading="lazy">
            <div class="meta">
              <div class="title"><?php echo $title; ?></div>
              <div class="author small"><?php echo $autor; ?></div>
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
