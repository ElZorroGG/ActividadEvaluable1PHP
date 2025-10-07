<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$logged = !empty($_SESSION["Usuario"]);
?>
<nav class="menu" id="site-menu">
  <div class="menu-inner">
  <div class="brand"><a href="/ActividadEvaluable1PHP/Session.php">Menú</a></div>
    <button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-label="Abrir menú">☰</button>
    <ul class="menu-list" id="menu-list">
        <?php if (!$logged): ?>
          <li><a href="/ActividadEvaluable1PHP/DatosUsuario/Registro.php">Registrarse</a></li>
          <li><a href="/ActividadEvaluable1PHP/DatosUsuario/login.php">Iniciar sesión</a></li>
        <?php else: ?>
          <li><a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/CreaBiblioteca.php">Crear juego</a></li>
          <li><a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php">Ver juegos</a></li>
          <li><a class="secondary" href="/ActividadEvaluable1PHP/cerrarSession.php">Cerrar sesión</a></li>
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
