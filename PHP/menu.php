<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
$logged = !empty($_SESSION["Usuario"]);
?>
<nav class="menu" id="site-menu">
  <div class="menu-inner">
  <div class="brand"><a href="../Recogida de datos/Session.php">Menú</a></div>
    <button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-label="Abrir menú">☰</button>
    <ul class="menu-list" id="menu-list">
      <?php if (!$logged): ?>
        <li><a href="../Recogida de datos/Registro.php">Registrarse</a></li>
        <li><a href="../Recogida de datos/login.php">Iniciar sesión</a></li>
      <?php else: ?>
        <li><a href="../Recogida de datos/CreaBiblioteca.php">Crear juego</a></li>
        <li><a href="../PHP/VerJuegos.php">Ver juegos</a></li>
        <li><a class="secondary" href="cerrarSession.php">Cerrar sesión</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<script>
  (function(){
    var btn = document.getElementById("menu-toggle");
    var menu = document.getElementById("site-menu");
    btn && btn.addEventListener("click", function(){
      var expanded = this.getAttribute("aria-expanded") === "true";
      this.setAttribute("aria-expanded", expanded ? "false" : "true");
      menu.classList.toggle("open");
    });
  })();
</script>
