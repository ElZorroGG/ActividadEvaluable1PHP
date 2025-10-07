<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["Usuario"])){
    header("Location: /ActividadEvaluable1PHP/login.php");
    die;
}

$error = $_SESSION["ErrorAñadirJuego"] ?? "";
$exito = $_SESSION["ExitoAñadirJuego"] ?? "";

$old = $_SESSION['arrayVariablesBiblioteca'] ?? [];
unset($_SESSION["ErrorAñadirJuego"], $_SESSION["ExitoAñadirJuego"], $_SESSION['arrayVariablesBiblioteca']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ingresar Juego</title>
    <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
</head>
<body>
            <div class="container">
                <?php include_once __DIR__ . '/../menu.php'; ?>
                <div class="panel">
                <h1>Ingresa un juego a la biblioteca</h1>

                <?php if (!empty($error)): ?>
                    <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (!empty($exito)): ?>
                    <div class="notice success"><?php echo htmlspecialchars($exito); ?></div>
                <?php endif; ?>

                <form action="/ActividadEvaluable1PHP/BibliotecaDeJuegos/Creabibliotecaphp.php" method="post" enctype="multipart/form-data">

                    <div class="form-row">
                        <label for="NombreJuego">Nombre del Juego:</label>
                        <input id="NombreJuego" name="Titulo" type="text" required value="<?php echo htmlspecialchars($old['Titulo'] ?? ''); ?>">
                    </div>

                    <div class="form-row">
                        <label for="Descripcion">Descripcion del Juego:</label>
                        <textarea id="Descripcion" name="Descripcion" rows="4"><?php echo htmlspecialchars($old['Descripcion'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-row">
                        <label for="Autor">Autor/Estudio creador del juego</label>
                        <input id="Autor" name="Autor" type="text" value="<?php echo htmlspecialchars($old['Autor'] ?? ''); ?>">
                    </div>

                    <div class="form-row">
                        <label for="Categoria">Categoria del juego:</label>
                        <select id="Categoria" name="Categoria">
                            <option value="Accion" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Accion') ? 'selected' : '';?>>Acción</option>
                            <option value="Aventura" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Aventura') ? 'selected' : '';?>>Aventura</option>
                            <option value="RPG" <?php echo (isset($old['Categoria']) && $old['Categoria']=='RPG') ? 'selected' : '';?>>RPG / Rol</option>
                            <option value="Estrategia" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Estrategia') ? 'selected' : '';?>>Estrategia (RTS/TBS)</option>
                            <option value="Shooter" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Shooter') ? 'selected' : '';?>>Shooter / FPS</option>
                            <option value="Simulacion" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Simulacion') ? 'selected' : '';?>>Simulación</option>
                            <option value="Deportes" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Deportes') ? 'selected' : '';?>>Deportes</option>
                            <option value="Carreras" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Carreras') ? 'selected' : '';?>>Carreras</option>
                            <option value="Puzzle" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Puzzle') ? 'selected' : '';?>>Puzzle / Rompecabezas</option>
                            <option value="Indie" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Indie') ? 'selected' : '';?>>Indie</option>
                            <option value="MMO" <?php echo (isset($old['Categoria']) && $old['Categoria']=='MMO') ? 'selected' : '';?>>MMO / Multijugador masivo</option>
                            <option value="Sandbox" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Sandbox') ? 'selected' : '';?>>Sandbox / Mundo abierto</option>
                            <option value="Horror" <?php echo (isset($old['Categoria']) && $old['Categoria']=='Horror') ? 'selected' : '';?>>Horror / Survival</option>
                            <option value="EstrategiaTactica" <?php echo (isset($old['Categoria']) && $old['Categoria']=='EstrategiaTactica') ? 'selected' : '';?>>Táctico / Estrategia por turnos</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="url">Enlace a la pagina oficial del juego:</label>
                        <input id="url" name="Url" type="text" value="<?php echo htmlspecialchars($old['Url'] ?? ''); ?>">
                    </div>

                    <div class="form-row">
                        <label for="Fecha">Año de salida del Juego</label>
                        <input id="Fecha" name="Fecha" type="number" min="1984" max="2030" value="<?php echo htmlspecialchars($old['Fecha'] ?? ''); ?>">
                    </div>

                    <div class="form-row file-input">
                        <label for="Portada">Portada</label>
                        <input id="Portada" name="Portada" type="file" accept="image/*">
                    </div>

                    <div class="form-row consejo-row">
                        <div class="card consejo-card">
                            <strong>Consejo:</strong>
                            <div class="small">Sube una portada clara en formato JPG o PNG. Max 5MB.</div>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit">Guardar juego</button>
                        <a class="button menu-btn" href="/ActividadEvaluable1PHP/Session.php">Volver</a>
                    </div>

                </form>
            </div>


                </div>
</body>
</html>
