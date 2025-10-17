<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ver Juegos</title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css?v=4">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>
<div class="container">
  <div class="panel">
    <h1>Juegos</h1>
    <?php if ($deleted ?? false): ?>
      <div class="notice success">Juego eliminado correctamente.</div>
    <?php endif; ?>
    <?php if ($error ?? false): ?>
      <div class="notice error">Error al eliminar el juego. Inténtalo de nuevo.</div>
    <?php endif; ?>
    <form style="margin-bottom: 20px; margin-top: 12px;">
        <input type="text" id="searchInput" size="30" placeholder="Buscar juegos..." style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
    </form>
    <div x-data="{tab: 'todos'}" style="margin-top:12px">
      <div class="tabs-menu" style="margin-bottom:12px;">
          <div class="tabs-inner" style="padding:8px;display:flex;gap:8px;justify-content:center;background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00));border-radius:10px;">
            <a href="#" :class='{"active-tab": tab==="todos"}' @click.prevent='tab="todos"' style="color:var(--accent);text-decoration:none;padding:8px 16px;border-radius:8px;border:1px solid transparent;transition:all .16s">Todos</a>
            <a href="#" :class='{"active-tab": tab==="mios"}' @click.prevent='tab="mios"' style="color:var(--accent);text-decoration:none;padding:8px 16px;border-radius:8px;border:1px solid transparent;transition:all .16s">Mis juegos</a>
          </div>
      </div>

      <div x-show="tab==='todos'">
        <div class="grid-games">
          <?php foreach (($games["todos"] ?? []) as $j):
            $img = $j["caratula"] ?: "/ActividadEvaluable1PHP/CaratulaPorDefecto/fc10656866244f57fe4aec109c76c84474539fef6ef3e066cf177edea6185202_749a89.png";
            if (!preg_match('#^(https?:)?//#', $img) && strpos($img, '/') !== 0) {
                $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
            }
            $title = $j["titulo"] ?? '';
            $autor = $j["autor"] ?? '';
            $bg = $img;
          ?>
          <a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$j["id"]; ?>" style="--bg-url: url('<?php echo $bg; ?>');">
            <div class="meta-overlay">
              <div class="meta">
                <div class="title"><?php echo $title; ?></div>
                <div class="author small"><?php echo $autor; ?></div>
                <div class="views-counter" style="display:flex;align-items:center;gap:4px;margin-top:6px;opacity:0.9;">
                  <span style="font-size:12px;"><?php echo number_format((int)($j["visualizaciones"] ?? 0)); ?> visitas</span>
                </div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div x-show="tab==='mios'" x-cloak>
        <div class="grid-games">
          <?php foreach (($games["mios"] ?? []) as $j):
            $img = $j["caratula"] ?: "/ActividadEvaluable1PHP/CaratulaPorDefecto/fc10656866244f57fe4aec109c76c84474539fef6ef3e066cf177edea6185202_749a89.png";
            if (!preg_match('#^(https?:)?//#', $img) && strpos($img, '/') !== 0) {
                $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
            }
            $title = $j["titulo"] ?? '';
            $autor = $j["autor"] ?? '';
            $bg = $img;
          ?>
          <a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$j["id"]; ?>" style="--bg-url: url('<?php echo $bg; ?>');">
            <div class="meta-overlay">
              <div class="meta">
                <div class="title"><?php echo $title; ?></div>
                <div class="author small"><?php echo $autor; ?></div>
                <div class="views-counter" style="display:flex;align-items:center;gap:4px;margin-top:6px;opacity:0.9;">
                  <span style="font-size:12px;"><?php echo number_format((int)($j["visualizaciones"] ?? 0)); ?> visitas</span>
                </div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        const query = e.target.value;
        window.location.href = '/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php' + (query ? '?q=' + encodeURIComponent(query) : '');
    }, 500);
});
</script>

</body>
</html>
