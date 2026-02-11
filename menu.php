<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$logged = !empty($_SESSION["Usuario"]);
$fotoPerfil = null;

if ($logged && !empty($_SESSION["user_id"])) {
    try {
        require_once __DIR__ . "/Conexion.php";
        if (isset($conn) && $conn !== null) {
            $stmt = $conn->prepare("SELECT foto_perfil FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([":id" => $_SESSION["user_id"]]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $fotoPerfil = $user["foto_perfil"];
                if ($fotoPerfil && strpos($fotoPerfil, "/") !== 0) {
                    $fotoPerfil = "/ActividadEvaluable1PHP/" . $fotoPerfil;
                }
            }
        }
    } catch (Exception $e) {
        $fotoPerfil = "/ActividadEvaluable1PHP/PerfilPorDefecto/Perfil.webp";
    }
}

if ($fotoPerfil === null) {
    $fotoPerfil = "/ActividadEvaluable1PHP/PerfilPorDefecto/Perfil.webp";
}
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
          <li><a href="/ActividadEvaluable1PHP/PerfilUsuario/EstadisticasJuegos.php">Estadísticas</a></li>
          <li><a class="secondary" href="/ActividadEvaluable1PHP/cerrarSession.php">Cerrar sesión</a></li>
          <li class="user-profile">
            <a href="/ActividadEvaluable1PHP/PerfilUsuario/EditarPerfil.php" title="Editar perfil">
              <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de perfil" class="profile-pic">
            </a>
          </li>
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
