<?php
session_start();
if (!isset($_SESSION["Usuario"])){
    header("location: login.php");
    die;
}

$error = $_SESSION["ErrorAñadirJuego"] ?? "";
$exito = $_SESSION["ExitoAñadirJuego"] ?? "";

unset($_SESSION["ErrorAñadirJuego"], $_SESSION["ExitoAñadirJuego"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ingresar Juego</title>
    <link rel="stylesheet" href="Estilo.css">
</head>
<body>
            <div class="container">
                <?php include_once "menu.php"; ?>
                <div class="panel">
                <h1>Ingresa un juego a la biblioteca</h1>

                <?php if (!empty($error)): ?>
                    <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (!empty($exito)): ?>
                    <div class="notice success"><?php echo htmlspecialchars($exito); ?></div>
                <?php endif; ?>

                <form action="Creabibliotecaphp.php" method="post" enctype="multipart/form-data">

                    <div class="form-row">
                        <label for="NombreJuego">Nombre del Juego:</label>
                        <input id="NombreJuego" name="Titulo" type="text" required>
                    </div>

                    <div class="form-row">
                        <label for="Descripcion">Descripcion del Juego:</label>
                        <textarea id="Descripcion" name="Descripcion" rows="4"></textarea>
                    </div>

                    <div class="form-row">
                        <label for="Autor">Autor/Estudio creador del juego</label>
                        <input id="Autor" name="Autor" type="text">
                    </div>

                    <div class="form-row">
                        <label for="Categoria">Categoria del juego:</label>
                        <select id="Categoria" name="Categoria">
                            <option value="RTS">Estrategia en tiempo real</option>
                            <option value="Shooter">Shooter</option>
                            <option value="Simulacion">Simulacion</option>
                            <option value="Carreras">Carreras</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="url">Enlace a la pagina oficial del juego:</label>
                        <input id="url" name="Url" type="text">
                    </div>

                    <div class="form-row">
                        <label for="Fecha">Año de salida del Juego</label>
                        <input id="Fecha" name="Fecha" type="number" min="1984" max="2030">
                    </div>

                    <div class="form-row file-input">
                        <label for="Portada">Portada</label>
                        <input id="Portada" name="Portada" type="file" accept="image/*">
                    </div>

                    <div class="actions">
                        <button type="submit">Guardar juego</button>
                        <a class="button secondary" href="Session.php">Volver</a>
                    </div>

                </form>
            </div>

            <aside class="side">
                <div class="card">
                    <strong>Consejo:</strong>
                    <div class="small">Sube una portada clara en formato JPG o PNG. Max 5MB.</div>
                </div>
                <div class="card">
                    <strong>Atajo:</strong>
                    <div class="small">Si no subes imagen se usará la carátula por defecto.</div>
                </div>
            </aside>

        </div>
  <p><a href="Session.php">Volver</a></p>
    <form action="logout.php" method="post" style="display:inline">
    <button type="submit">Cerrar sesión</button>
  </form>
</body>
</html>
</body>











</html>