<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($game["titulo"]); ?></title>
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/Estilo.css">
  <link rel="stylesheet" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuego.css">
</head>
<body>
<?php include __DIR__ . '/../menu.php'; ?>

<div class="container">
  <div class="panel">
    <div class="game-detail-vj">
      <h1 class="title-vj"><?php echo htmlspecialchars($game["titulo"]); ?></h1>
      <div class="cover-vj">
        <?php
        $caratula = $game["caratula"] ?: 'CaratulaPorDefecto/default.jpg';
        if (!preg_match('#^(https?:)?//#', $caratula) && strpos($caratula, '/') !== 0) {
            $caratula = '/ActividadEvaluable1PHP/' . ltrim($caratula, '/\\');
        }
        ?>
        <img src="<?php echo htmlspecialchars($caratula); ?>" alt="<?php echo htmlspecialchars($game["titulo"]); ?>">
      </div>
      <div class="details-vj" style="margin-top:12px">
        <p class="small">Autor / Estudio: <?php echo htmlspecialchars($game["autor"]); ?></p>
        <p class="small">Categoría: <?php echo htmlspecialchars($game["categoria"]); ?></p>
        <p class="small">Año: <?php echo htmlspecialchars($game["anio"]); ?></p>
        <div class="estadisticas-vj" style="margin:16px 0;padding:12px;background:linear-gradient(90deg, rgba(0,229,255,0.08), rgba(124,255,111,0.08));border-radius:8px;border:1px solid rgba(0,229,255,0.15);">
          <p class="small" style="margin:0;display:flex;align-items:center;gap:8px;">
            <strong style="color:var(--accent);">Visitas:</strong> 
            <span style="font-weight:700;font-size:16px;color:var(--accent);"><?php echo number_format((int)($game["visualizaciones"] ?? 0)); ?></span>
          </p>
        </div>
        <h3>Descripción</h3>
        <p><?php echo nl2br(htmlspecialchars($game["descripcion"])); ?></p>
        <?php if (!empty($game["url"])): ?>
          <p><a href="<?php echo htmlspecialchars($game["url"]); ?>" target="_blank">Sitio oficial</a></p>
        <?php endif; ?>
      </div>
      
      <div class="voting-section">
        <h3>¿Recomendarías este juego?</h3>
        <div class="vote-buttons">
          <button class="vote-btn upvote <?php echo (isset($game['user_vote']) && $game['user_vote'] === 1) ? 'active' : ''; ?> <?php echo (isset($game['user_vote']) && $game['user_vote'] === 0) ? 'hidden' : ''; ?>" 
                  data-vote-type="1" 
                  data-game-id="<?php echo (int)$game['id']; ?>"
                  title="Me gusta">
            <span class="vote-icon">👍</span>
            <span class="vote-count upvote-count"><?php echo (int)($game['upvote'] ?? 0); ?></span>
          </button>
          
          <button class="vote-btn downvote <?php echo (isset($game['user_vote']) && $game['user_vote'] === 0) ? 'active' : ''; ?> <?php echo (isset($game['user_vote']) && $game['user_vote'] === 1) ? 'hidden' : ''; ?>" 
                  data-vote-type="0" 
                  data-game-id="<?php echo (int)$game['id']; ?>"
                  title="No me gusta">
            <span class="vote-icon">👎</span>
            <span class="vote-count downvote-count"><?php echo (int)($game['downvote'] ?? 0); ?></span>
          </button>
        </div>
        <div class="vote-message" id="vote-message"></div>
        <?php 
        $totalVotes = (int)($game['upvote'] ?? 0) + (int)($game['downvote'] ?? 0);
        if ($totalVotes > 0) {
          $percentage = round(((int)($game['upvote'] ?? 0) / $totalVotes) * 100);
          echo '<div class="vote-stats">';
          echo '<span>Total: ' . $totalVotes . '</span>';
          echo '<span>•</span>';
          echo '<span>' . $percentage . '% 👍</span>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

    <div class="panel-footer-vj">
      <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php">Volver a la lista</a>
      <?php if ((int)($game["user_id"] ?? 0) === (int)($_SESSION["user_id"] ?? $_SESSION["id"] ?? 0)): ?>
        <a class="button menu-btn" href="/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegoEditar.php?id=<?php echo (int)$game["id"]; ?>">Editar</a>
        <form method="post" action="/ActividadEvaluable1PHP/BibliotecaDeJuegos/EliminarJuego.php" style="display:inline-block;margin:0;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este juego? Esta acción no se puede deshacer.');">
          <input type="hidden" name="id" value="<?php echo (int)$game["id"]; ?>">
          <button type="submit" class="button secondary" style="background:linear-gradient(90deg,var(--danger), #ff7a8b);color:#fff;border:none;">Eliminar</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const voteButtons = document.querySelectorAll('.vote-btn');
    const upvoteBtn = document.querySelector('.vote-btn.upvote');
    const downvoteBtn = document.querySelector('.vote-btn.downvote');
    
    voteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const voteType = parseInt(this.dataset.voteType);
            const gameId = parseInt(this.dataset.gameId);
            
            voteButtons.forEach(btn => btn.style.pointerEvents = 'none');
            
            fetch('/ActividadEvaluable1PHP/BibliotecaDeJuegos/VotarJuego.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'game_id=' + gameId + '&vote_type=' + voteType
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.upvote-count').textContent = data.upvotes;
                    document.querySelector('.downvote-count').textContent = data.downvotes;
                    
                    voteButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.remove('hidden');
                    });
                    
                    if (data.userVote !== null && data.userVote !== undefined) {
                        const userVoteInt = parseInt(data.userVote);
                        if (userVoteInt === 1) {
                            upvoteBtn.classList.add('active');
                            downvoteBtn.classList.add('hidden');
                        } else if (userVoteInt === 0) {
                            downvoteBtn.classList.add('active');
                            upvoteBtn.classList.add('hidden');
                        }
                    }
                    
                    const totalVotes = data.upvotes + data.downvotes;
                    const voteStatsContainer = document.querySelector('.vote-stats');
                    
                    if (totalVotes > 0) {
                        const percentage = Math.round((data.upvotes / totalVotes) * 100);
                        if (voteStatsContainer) {
                            voteStatsContainer.innerHTML = 
                                '<span>Total: ' + totalVotes + '</span>' +
                                '<span>•</span>' +
                                '<span>' + percentage + '% 👍</span>';
                        } else {
                            const statsDiv = document.createElement('div');
                            statsDiv.className = 'vote-stats';
                            statsDiv.innerHTML = 
                                '<span>Total: ' + totalVotes + '</span>' +
                                '<span>•</span>' +
                                '<span>' + percentage + '% 👍</span>';
                            document.querySelector('.voting-section').appendChild(statsDiv);
                        }
                    } else if (voteStatsContainer) {
                        voteStatsContainer.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                voteButtons.forEach(btn => btn.style.pointerEvents = 'auto');
            });
        });
    });
});
</script>

</body>
</html>
