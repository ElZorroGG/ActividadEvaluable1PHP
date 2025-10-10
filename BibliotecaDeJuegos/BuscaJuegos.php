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
    <script>
        function showResult(str) {
        if (str.length==0) {
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            return;
        }
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                document.getElementById("livesearch").innerHTML=this.responseText;
                document.getElementById("livesearch").style.border="1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "BuscaArchivos.php?q=" + str, true);
    xmlhttp.send();
    
}
        </script>
</head>
<body>
    <form>
        <input type="text" size="30" onkeyup="showResult(this.value)">
        <div id="livesearch"></div>
        </form>
        <div class="container">
  <div class="panel">
    <h1>Juegos</h1>
    <div x-data="{tab: 'todos'}" style="margin-top:12px">
      <div class="menu" style="margin-bottom:8px;">
          <div class="menu-inner" style="padding:8px">
          <div class="menu-list">
          </div>
        </div>
      </div>

        <div class="grid-games">
            <script>Script=JSON.parse($games)
          <?php foreach (($games ?? []) as $j):
            $img = $j["caratula"] ?: "CaratulaPorDefecto/default.jpg";
            if (!preg_match('#^(https?:)?//#', $img) && strpos($img, '/') !== 0) {
                $img = '/ActividadEvaluable1PHP/' . ltrim($img, '/\\');
            }
            $title = htmlspecialchars($j["titulo"]);
            $autor = htmlspecialchars($j["autor"]);
          ?>
          <?php $bg = htmlspecialchars($img); ?>
          <a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$j["id"]; ?>" style="--bg-url: url('<?php echo $bg; ?>');">
            <div class="meta-overlay">
              <div class="meta">
                <div class="title"><?php echo $title; ?></div>
                <div class="author small"><?php echo $autor; ?></div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>

</body>

</body>
</body>
