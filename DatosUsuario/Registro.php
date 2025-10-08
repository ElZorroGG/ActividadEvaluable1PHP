<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
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
  <script>
    function showHint(str) {
      if (str.length == 0) {
    document.getElementById("Sugerencia").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("Sugerencia").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "VerificacionContraseña.php?q=" + str, true);
    xmlhttp.send();
  }
}
document.addEventListener('DOMContentLoaded',function (){
  showHint(str)});
    
  </script>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
   <title>Registro</title>
</head>
<body>
<div class="container">
  <?php include_once __DIR__ . '/../menu.php'; ?>
  <div class="panel">
    <h1>Registro</h1>
    <?php if ($error): ?>
      <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

  <form action="/ActividadEvaluable1PHP/DatosUsuario/Formulario.php" method="post" id="Formulario">
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
        <input name="contraseña" id="contraseña" required onkeyup="showHint(this.value)" type="password" required>
      </div>

      <div class="form-row">
        <label for="CorfirmaContraseña">Confirmar contraseña</label>
        <input name="CorfirmaContraseña" id="CorfirmaContraseña" type="password">
      </div>
      <p id="Sugerencia"><span id="txtHint"></span></p>

      <div class="actions">
        <button type="submit">Validar</button>
  <a class="menu-btn" href="/ActividadEvaluable1PHP/DatosUsuario/login.php">Volver</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>