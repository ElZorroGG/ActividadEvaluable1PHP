<?php
session_start();
if (!isset($_SESSION["Usuario"])){
    header("location: login.php");
    die;
}
$error =$_SESSION["ErrorAñadirJuego"];
$exito=$_SESSION["ExitoAñadirJuego"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ingresar Juego</title>
    <link rel="stylesheet" href="Estilo.css">
</head>
<body>
    <h1>Ingresa un juego a la biblioteca</h1>
    <form action="Creabibliotecaphp.php" method="post" enctype="multipart/form-data">

        <label for="NombreJuego">Nombre del Juego: </label>
        <input id="NombreJuego" name="Titulo" type="text" required>
        
        <label for="Descripcion">Descripcion del Juego: </label>
        <textarea id="Descripcion" name="Descripcion" rows="4"></textarea>

        <label for="Categoria">Categoria del juego:</label>
        <select id="Categoria" name="Categoria" form="formularioCategoria">
            <option value="RTS">Estrategia en tiempo real</option>
            <option value="Shooter">Shooter</option>
            <option value="Simulacion">Simulacion</option>
            <option value="Carreras">Carreras</option>
        </select>

        <label for="url">Enlace a la pagina oficial del juego: </label>
        <input id="url" name="url" type="text">

        <label for="fecha">Año de salida del Juego</label>
        <input id="fecha" name="fecha" type="number" min="1984"max="2030">

        <label for="Portada">Portada</label>
        <input id="Portada" name="Portada" type="file" accept="image/*">

        <button type="submit">Guardar juego</button>


    </form>
  <p><a href="Session.php">Volver</a></p>
    <form action="logout.php" method="post" style="display:inline">
    <button type="submit">Cerrar sesión</button>
  </form>
</body>
</html>
</body>











</html>