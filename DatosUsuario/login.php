<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$error = $_SESSION["ErrorLogin"] ?? "";
$prefill = $_SESSION["nombre_login"] ?? $_SESSION["nombre"] ?? "";
unset($_SESSION["ErrorLogin"], $_SESSION["nombre_login"]);
?>

<div class="container">
  <?php include_once __DIR__ . '/../menu.php'; ?>
  <div class="panel">
    <h1>Iniciar sesión</h1>
    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

  <form action="/ActividadEvaluable1PHP/DatosUsuario/AutenticacionLogin.php" method="post">
      <div class="form-row">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" value="<?php echo htmlspecialchars($prefill); ?>" required>
      </div>

      <div class="form-row">
        <label for="contrasena">Contraseña</label>
        <input id="contrasena" name="contrasena" type="password" required>
      </div>

      <div class="form-row">
        <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);">
          <input type="checkbox" name="recordar" value="1" style="margin:0;">
          <a>Recordad la sesion por 1 hora</a>
        </label>
      </div>

      <div class="actions">
        <button type="submit" style="display:none">Entrar</button>
      </div>

      <div class="menu" style="margin-top:12px;display:flex;justify-content:center">
        <div class="menu-inner" style="padding:6px 8px">
          <div class="menu-list">
            <button type="submit" formmethod="post" formaction="/ActividadEvaluable1PHP/DatosUsuario/AutenticacionLogin.php">Entrar</button>
          </div>
        </div>
      </div>

  <div style="text-align:center;margin-top:8px;color:var(--muted)">o también puedes <a class="menu-btn" href="/ActividadEvaluable1PHP/DatosUsuario/Registro.php">registrarte</a></div>
    </form>
  </div>
</div>

</body>
</html>