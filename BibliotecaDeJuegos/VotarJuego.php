<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["Usuario"]) || !isset($_SESSION["user_id"])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión para votar'
    ]);
    exit;
}

require_once __DIR__ . '/../Conexion.php';

$gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
$voteType = isset($_POST['vote_type']) ? (int)$_POST['vote_type'] : -1;
$userId = (int)$_SESSION["user_id"];

if ($gameId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de juego inválido'
    ]);
    exit;
}

if ($voteType !== 0 && $voteType !== 1) {
    echo json_encode([
        'success' => false,
        'message' => 'Tipo de voto inválido'
    ]);
    exit;
}

try {
    $stmtGame = $conn->prepare("SELECT id, user_id FROM bibliotecajuegos WHERE id = :game_id LIMIT 1");
    $stmtGame->execute([':game_id' => $gameId]);
    $game = $stmtGame->fetch(PDO::FETCH_ASSOC);
    
    if (!$game) {
        echo json_encode([
            'success' => false,
            'message' => 'El juego no existe'
        ]);
        exit;
    }
    
    if ((int)$game['user_id'] === $userId) {
        echo json_encode([
            'success' => false,
            'message' => 'No puedes votar tu propio juego'
        ]);
        exit;
    }
    
    $stmtCheck = $conn->prepare("SELECT vote_type FROM game_votes WHERE user_id = :user_id AND game_id = :game_id LIMIT 1");
    $stmtCheck->execute([':user_id' => $userId, ':game_id' => $gameId]);
    $existingVote = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
    if ($existingVote) {
        echo json_encode([
            'success' => false,
            'message' => 'Ya has votado este juego. El voto es permanente.'
        ]);
        exit;
    }
    
    $conn->beginTransaction();
    
    $stmtInsert = $conn->prepare("INSERT INTO game_votes (user_id, game_id, vote_type) VALUES (:user_id, :game_id, :vote_type)");
    $stmtInsert->execute([':user_id' => $userId, ':game_id' => $gameId, ':vote_type' => $voteType]);
        
        if ($voteType === 1) {
            $conn->prepare("UPDATE bibliotecajuegos SET upvote = upvote + 1 WHERE id = :game_id")
                 ->execute([':game_id' => $gameId]);
        } else {
            $conn->prepare("UPDATE bibliotecajuegos SET downvote = downvote + 1 WHERE id = :game_id")
                 ->execute([':game_id' => $gameId]);
        }
        
        $conn->commit();
        
        $stmtCounts = $conn->prepare("SELECT upvote, downvote FROM bibliotecajuegos WHERE id = :game_id LIMIT 1");
        $stmtCounts->execute([':game_id' => $gameId]);
        $counts = $stmtCounts->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'action' => 'added',
            'message' => 'Voto registrado',
            'upvotes' => (int)$counts['upvote'],
            'downvotes' => (int)$counts['downvote'],
            'userVote' => $voteType
        ]);
        exit;
    
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el voto: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo json_encode([
        'success' => false,
        'message' => 'Error inesperado: ' . $e->getMessage()
    ]);
    exit;
}
