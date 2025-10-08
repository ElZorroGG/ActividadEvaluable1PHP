<?php
    $q = $_REQUEST["q"];
     echo "Es mayor de 8 caracteres <br>";
     echo  "una mayúscula <br>";
     echo "una minúscula<br>";
     echo " un número <br>";
     echo " un carácter especial <br>";
  $len=strlen($q);
    if (!preg_match('/[A-Z]/', $q)) ;;
    if (!preg_match('/[a-z]/', $q));
    if (!preg_match('/[0-9]/', $q));
    if (!preg_match('/[\W_]/', $q));
    if(strlen($q)<8);
    
?>