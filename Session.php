<?php
session_start();
if (!isset($_SESSION['Usuario'])) {
    header('Location: login.php');
    exit;
}
require_once 'Conexion.php';

$userId = (int)($_SESSION['user_id'] ?? 0);

try {
    $stmtAll = $conn->query("SELECT * FROM bibliotecajuegos ORDER BY id DESC");
    $todos = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $todos = [];
}

try {
    $stmtMine = $conn->prepare("SELECT * FROM bibliotecajuegos WHERE user_id = :uid ORDER BY id DESC");
    $stmtMine->execute([':uid' => $userId]);
    $mios = $stmtMine->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $mios = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Sesión</title>
    <link rel="stylesheet" href="Estilo.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>

<div class="container">
    <div class="panel">
        <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['Usuario']); ?></h1>
        <form action="cerrarSession.php" method="post" style="display:inline">
            <button type="submit" class="button secondary">Cerrar sesión</button>
        </form>

        <div x-data="{tab: 'todos'}" style="margin-top:18px">
            <div class="menu" style="margin-bottom:8px;">
                <div class="menu-inner" style="padding:8px">
                    <div class="brand">Ver juegos</div>
                    <div class="menu-list">
                        <a href="#" :class="{ 'active-tab': tab==='todos' }" @click.prevent="tab='todos'">Todos</a>
                        <a href="#" :class="{ 'active-tab': tab==='mios' }" @click.prevent="tab='mios'">Mis juegos</a>
                    </div>
                </div>
            </div>

            <div x-show="tab==='todos'">
                <div class="grid-games">
                    <?php foreach ($todos as $j):
                        $img = htmlspecialchars($j['caratula'] ?: 'CaratulaPorDefecto/default.jpg');
                        $title = htmlspecialchars($j['titulo']);
                        $autor = htmlspecialchars($j['autor']);
                    ?>
                    <div class="game-card">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" class="cover">
                        <div class="meta">
                            <div class="title"><?php echo $title; ?></div>
                            <div class="author small"><?php echo $autor; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div x-show="tab==='mios'" x-cloak>
                <div class="grid-games">
                    <?php foreach ($mios as $j):
                        $img = htmlspecialchars($j['caratula'] ?: 'CaratulaPorDefecto/default.jpg');
                        $title = htmlspecialchars($j['titulo']);
                        $autor = htmlspecialchars($j['autor']);
                    ?>
                    <div class="game-card">
                        <img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" class="cover">
                        <div class="meta">
                            <div class="title"><?php echo $title; ?></div>
                            <div class="author small"><?php echo $autor; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
