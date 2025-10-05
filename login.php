<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="Estilo.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
session_start();
$error = $_SESSION['ErrorLogin'] ?? '';
$prefill = $_SESSION['nombre_login'] ?? $_SESSION['nombre'] ?? '';
unset($_SESSION['ErrorLogin'], $_SESSION['nombre_login']);
?>

<div class="container">
  <div class="panel">
    <h1>Iniciar sesión</h1>
    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="AutenticacionLogin.php" method="post">
      <div class="form-row">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" value="<?php echo htmlspecialchars($prefill); ?>" required>
      </div>

      <div class="form-row">
        <label for="contrasena">Contraseña</label>
        <input id="contrasena" name="contrasena" type="password" required>
      </div>

      <div class="actions">
        <button type="submit">Entrar</button>
        <a class="button secondary" href="Registro.php">Regístrate</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
