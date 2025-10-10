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
            location.reload();
            return;
        }
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                try {
                    const games = JSON.parse(this.responseText);
                    let html = '';
                    games.forEach(function(game) {
                        let img = game.caratula || '/ActividadEvaluable1PHP/CaratulaPorDefecto/fc10656866244f57fe4aec109c76c84474539fef6ef3e066cf177edea6185202_749a89.png';
                        if (!img.match(/^(https?:)?\/\//) && img.indexOf('/') !== 0) {
                            img = '/ActividadEvaluable1PHP/' + img.replace(/^[\/\\]+/, '');
                        }
                        const title = (game.titulo || '').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                        const author = (game.autor || '').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                        
                        html += '<a class="game-card" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=' + game.id + '" style="--bg-url: url(\'' + img + '\');">';
                        html += '<div class="meta-overlay">';
                        html += '<div class="meta">';
                        html += '<div class="title">' + title + '</div>';
                        html += '<div class="author small">' + author + '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</a>';
                    });
                    document.querySelector(".grid-games").innerHTML = html;
                } catch(e) {
                    document.querySelector(".grid-games").innerHTML = '<p>Error al cargar los resultados</p>';
                }
            }
        }
            xmlhttp.open("GET", "BuscaArchivos.php?q=" + str, true);
            xmlhttp.send();
        }
        </script>
</head>
<body>
        <div class="container">
  <div class="panel">
    <h1>Juegos</h1>
    <form style="margin-bottom: 20px;">
        <input type="text" size="30" onkeyup="showResult(this.value)" placeholder="Buscar juegos..." style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </form>

          </div>
        </div>
      </div>

</body>

</body>
</body>
