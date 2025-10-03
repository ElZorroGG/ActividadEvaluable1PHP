<!DOCTYPE html>
<html>
   <header>
      <link rel="stylesheet" href="estilo.css">
   </header>
<body>
   <?php 
      session_start();
   ?>

<form action="Formulario.php" method="post" id="Formulario">
   <label>Su nombre :</label>
   <input name="nombre" id="nombre" type="text"  class=nombre value=<?php echo $_SESSION["nombre"] ?>><br>

   <label>Su Mail :</label>
   <input name="email" id="email" type="text" class=mail value=<?php echo $_SESSION["mail"] ?> ><br>

   <label>Su contraseña :</label>
   <input name="contraseña" id="contraseña" type="text"class=contraseña value=<?php echo $_SESSION["contraseña"] ?>><br>

   <label>Confirmar contraseña :</label>
   <input name="CorfirmaContraseña" id="contraseña" type="text" class="confirma"value=<?php echo $_SESSION["contraseña"] ?>><br>

   <button type="submit">Validar</button>
</form>

<?php 
   if(isset($_SESSION["Error"])&& $_SESSION["Error"]!=''){
      Echo $_SESSION["Error"].".";
      $_SESSION["Error"] = "";
   }
?>

</body>
</html>