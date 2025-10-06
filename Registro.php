<?php
session_start();
$error = $_SESSION["Error"] ?? "";
$prefill = [
  "nombre" => $_SESSION["nombre"] ?? "",
  "mail" => $_SESSION["mail"] ?? ""
];
unset($_SESSION["Error"], $_SESSION["nombre"], $_SESSION["mail"], $_SESSION["contraseña"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <link rel="stylesheet" href="Estilo.css">
   <title>Registro</title>
</head>
<body>
<div class="container">
  <?php include_once "menu.php"; ?>
  <div class="panel">
    <h1>Registro</h1>
    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="Formulario.php" method="post" id="Formulario">
      <div class="form-row">
        <label for="nombre">Su nombre</label>
        <input name="nombre" id="nombre" type="text" value="<?php echo htmlspecialchars($prefill["nombre"]); ?>" required>
      </div>

      <div class="form-row">
        <label for="email">Su Mail</label>
        <input name="email" id="email" type="email" value="<?php echo htmlspecialchars($prefill["mail"]); ?>" required>
      </div>

      <div class="form-row">
        <label for="contraseña">Su contraseña</label>
        <input name="contraseña" id="contraseña" type="password" required>
      </div>

      <div class="form-row">
        <label for="CorfirmaContraseña">Confirmar contraseña</label>
        <input name="CorfirmaContraseña" id="CorfirmaContraseña" type="password" required>
      </div>

      <div class="actions">
        <button type="submit">Validar</button>
        <a class="button secondary" href="login.php">Volver</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>