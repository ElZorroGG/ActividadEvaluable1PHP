<?php
    $q = $_REQUEST["q"];
  $len=strlen($q);
    if (!preg_match('/[A-Z]/', $q)) echo "<span style='color: red;'>una mayúscula</span><br>";else echo "<span style='color: green;'>una mayúscula</span><br>";
    if (!preg_match('/[a-z]/', $q)) echo "<span style='color: red;'>una minúscula</span><br>";else echo "<span style='color: green;'>una minúscula</span><br>";
    if (!preg_match('/[0-9]/', $q)) echo "<span style='color: red;'>un número</span><br>";else echo "<span style='color: green;'>un número</span><br>";
    if (!preg_match('/[\W_]/', $q)) echo "<span style='color: red;'>un carácter especial</span><br>";else echo "<span style='color: green;'>un carácter especial</span><br>";
    if(strlen($q)<8) echo "<span style='color: red;'>más de 8 caracteres</span><br>";else echo "<span style='color: green;'>más de 8 caracteres</span><br>";

?>