<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$error = $_SESSION["ErrorEditar"] ?? "";
$success = $_SESSION["ExitoEditar"] ?? "";
unset($_SESSION["ErrorEditar"], $_SESSION["ExitoEditar"]);

if (!isset($game)) {
  if (!isset($_SESSION["Usuario"])) {
    header("Location: /ActividadEvaluable1PHP/login.php");
    exit;
  }

  $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
  if ($id <= 0) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
  }

  require_once __DIR__ . '/../Conexion.php';
  try {
    $stmt = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE id = :id LIMIT 1");
    $stmt->execute([":id" => $id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    $game = false;
  }

  if (!$game) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
  }

  $ownerId = (int)($game["user_id"] ?? 0);
  $currentUser = (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0);
  if ($ownerId !== $currentUser) {
    header("Location: /ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Editar <?php echo htmlspecialchars($game["titulo"]); ?></title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>

<div class="container">
  <div class="panel">
    <h1>Editar juego</h1>
    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="notice success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

  <form action="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditarphp.php?id=<?php echo (int)$game["id"]; ?>" method="post" enctype="multipart/form-data">
      <div class="form-row">
        <label for="Titulo">Titulo</label>
        <input id="Titulo" name="Titulo" type="text" value="<?php echo htmlspecialchars($game["titulo"]); ?>" required>
      </div>

      <div class="form-row">
        <label for="Descripcion">Descripcion</label>
        <textarea id="Descripcion" name="Descripcion"><?php echo htmlspecialchars($game["descripcion"]); ?></textarea>
      </div>

      <div class="form-row">
        <label for="Autor">Autor</label>
        <input id="Autor" name="Autor" type="text" value="<?php echo htmlspecialchars($game["autor"]); ?>">
      </div>

      <div class="form-row">
        <div class="form-row">
                        <label for="Categoria">Categoria del juego:</label>
                        <select id="Categoria" name="Categoria" value="<?php echo htmlspecialchars($game["categoria"]); ?>" >
                            <option value="Accion" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Accion') ? 'selected' : '';?>>Acción</option>
                            <option value="Aventura" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Aventura') ? 'selected' : '';?>>Aventura</option>
                            <option value="RPG" <?php echo (isset($old['Categoria']) && $old['Categoria']=='RPG') ? 'selected' : '';?>>RPG / Rol</option>
                            <option value="Estrategia" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Estrategia') ? 'selected' : '';?>>Estrategia (RTS/TBS)</option>
                            <option value="Shooter" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Shooter') ? 'selected' : '';?>>Shooter / FPS</option>
                            <option value="Simulacion" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Simulacion') ? 'selected' : '';?>>Simulación</option>
                            <option value="Deportes" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Deportes') ? 'selected' : '';?>>Deportes</option>
                            <option value="Carreras" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Carreras') ? 'selected' : '';?>>Carreras</option>
                            <option value="Puzzle" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Puzzle') ? 'selected' : '';?>>Puzzle / Rompecabezas</option>
                            <option value="Indie" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Indie') ? 'selected' : '';?>>Indie</option>
                            <option value="MMO" <?php echo (isset($old['Categoria']) && $old['Categoria']=='MMO') ? 'selected' : '';?>>MMO / Multijugador masivo</option>
                            <option value="Sandbox" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Sandbox') ? 'selected' : '';?>>Sandbox / Mundo abierto</option>
                            <option value="Horror" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Horror') ? 'selected' : '';?>>Horror / Survival</option>
                            <option value="EstrategiaTactica" <?php echo (isset($old['Categoria']) && $old['Categoria']=='EstrategiaTactica') ? 'selected' : '';?>>Táctico / Estrategia por turnos</option>
                        </select>
                    </div>
      </div>

      <div class="form-row">
        <label for="Url">Url</label>
        <input id="Url" name="Url" type="text" value="<?php echo htmlspecialchars($game["url"]); ?>">
      </div>

      <div class="form-row">
        <label for="Fecha">Año</label>
        <input id="Fecha" name="Fecha" min="1984" type="number" value="<?php echo htmlspecialchars($game["anio"]); ?>">
      </div>

      <div class="form-row file-input">
        <label for="Portada">Portada (dejar en blanco para conservar actual)</label>
        <input id="Portada" name="Portada" type="file" accept="image/*">
      </div>

  <div class="actions">
    <button type="submit">Guardar cambios</button>
  <a class="menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$game["id"]; ?>">Cancelar</a>
  </div>
    </form>
  </div>
</div>
</body>
</html>
