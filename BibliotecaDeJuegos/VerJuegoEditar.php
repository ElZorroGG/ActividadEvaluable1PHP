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
        <label for="Categoria">Categoria</label>
        <input id="Categoria" name="Categoria" type="text" value="<?php echo htmlspecialchars($game["categoria"]); ?>">
      </div>

      <div class="form-row">
        <label for="Url">Url</label>
        <input id="Url" name="Url" type="text" value="<?php echo htmlspecialchars($game["url"]); ?>">
      </div>

      <div class="form-row">
        <label for="Fecha">Año</label>
        <input id="Fecha" name="Fecha" type="number" value="<?php echo htmlspecialchars($game["anio"]); ?>">
      </div>

      <div class="form-row file-input">
        <label for="Portada">Portada (dejar en blanco para conservar actual)</label>
        <input id="Portada" name="Portada" type="file" accept="image/*">
      </div>

      <div class="actions">
        <button type="submit">Guardar cambios</button>
  <a class="button secondary" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$game["id"]; ?>">Cancelar</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
