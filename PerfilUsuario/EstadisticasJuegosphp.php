<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Estadísticas de Mis Juegos</title>
    <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css?v=5">
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>

<div class="container">
    <div class="panel">
        <h1>Estadísticas de Mis Juegos</h1>
        
        <div class="stats-summary">
            <div class="stat-card">
                <h3>Total de Juegos</h3>
                <div class="stat-value"><?php echo $totalJuegos; ?></div>
            </div>
            <div class="stat-card">
                <h3>Visitas Totales</h3>
                <div class="stat-value"><?php echo number_format($totalVisitas); ?></div>
            </div>
            <div class="stat-card">
                <h3>Promedio de Visitas</h3>
                <div class="stat-value"><?php echo $totalJuegos > 0 ? number_format($totalVisitas / $totalJuegos, 1) : 0; ?></div>
            </div>
        </div>

        <?php if (empty($juegos)): ?>
            <div class="no-games">
                <p>Aún no has creado ningún juego.</p>
                <p><a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/CreaBiblioteca.php" class="menu-btn">Crear mi primer juego</a></p>
            </div>
        <?php else: ?>
            <h2 style="margin-top: 32px; margin-bottom: 16px;">Ranking de Tus Juegos</h2>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">#</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Año</th>
                        <th style="text-align: right;">Visitas</th>
                        <th style="width: 100px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($juegos as $index => $juego): 
                        $rank = $index + 1;
                        $rankClass = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-other'));
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <span class="rank <?php echo $rankClass; ?>"><?php echo $rank; ?></span>
                        </td>
                        <td class="game-title"><?php echo htmlspecialchars($juego['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($juego['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($juego['anio']); ?></td>
                        <td style="text-align: right;" class="views-count"><?php echo number_format((int)$juego['visualizaciones']); ?></td>
                        <td style="text-align: center;">
                            <a href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.php?id=<?php echo (int)$juego['id']; ?>" style="color:var(--accent);text-decoration:none;font-size:12px;">Ver</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="actions" style="margin-top: 24px;">
            <a class="menu-btn" href="/ActividadEvaluable1PHP/Session.php">Volver al inicio</a>
            <a class="menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php">Ver todos los juegos</a>
        </div>
    </div>
</div>

</body>
</html>
