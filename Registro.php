<?php
session_start();
$error = $_SESSION['Error'] ?? '';
$prefill = [
   'nombre' => $_SESSION['nombre'] ?? '',
   'mail' => $_SESSION['mail'] ?? ''
];
unset($_SESSION['Error'], $_SESSION['nombre'], $_SESSION['mail'], $_SESSION['contraseña']);
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <link rel="stylesheet" href="Estilo.css">
   <title>Registro</title>
</head>
<body>
   <div class="container">
      <div class="panel" style="max-width:480px;margin:auto;">
         <h1>Registro</h1>
         <?php if ($error): ?>
            <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
         <?php endif; ?>

         <form action="Formulario.php" method="post" id="Formulario">
            <div class="form-row">
               <label for="nombre">Su nombre</label>
               <input name="nombre" id="nombre" type="text" value="<?php echo htmlspecialchars($prefill['nombre']); ?>">
            </div>

            <div class="form-row">
               <label for="email">Su Mail</label>
               <input name="email" id="email" type="text" value="<?php echo htmlspecialchars($prefill['mail']); ?>">
            </div>

            <div class="form-row">
               <label for="contraseña">Su contraseña</label>
               <input name="contraseña" id="contraseña" type="password">
            </div>

            <div class="form-row">
               <label for="CorfirmaContraseña">Confirmar contraseña</label>
               <input name="CorfirmaContraseña" id="CorfirmaContraseña" type="password">
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