<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="Estilo.css">
</head>
<body>
<?php
session_start();
$error = $_SESSION['ErrorLogin'] ?? '';
$prefill = $_SESSION['nombre_login'] ?? $_SESSION['nombre'] ?? '';


unset($_SESSION['ErrorLogin'], $_SESSION['nombre_login']);
?>

<h1>Iniciar sesión</h1>
<?php if ($error): ?>
  <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form action="AutenticacionLogin.php" method="post">
  <label for="nombre">Nombre :</label>
  <input id="nombre" name="nombre" type="text" value="<?php echo htmlspecialchars($prefill); ?>" required>

  <label for="contrasena">Contraseña :</label>
  <input id="contrasena" name="contrasena" type="password" required>

  <button type="submit">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="Registro.php">Regístrate</a></p>

<?php if (isset($_SESSION['Usuario'])): ?>
  <form action="cerrarSession.php" method="post" style="display:inline">
    <button type="submit">Cerrar sesión</button>
  </form>
<?php endif; ?>

</body>
</html>
