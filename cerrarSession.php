<?php
require_once __DIR__ . "/verificarSesion.php";

$_SESSION = [];
cerrarSesionCompleta();
header("Location: /ActividadEvaluable1PHP/DatosUsuario/login.php");
exit;
