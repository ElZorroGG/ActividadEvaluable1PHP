<?php
require_once __DIR__ . '/Conexion.php';

$usuarios = [
    ['nombre' => 'Carlos', 'password' => password_hash('carlos123', PASSWORD_DEFAULT), 'mail' => 'carlos@example.com'],
    ['nombre' => 'Maria', 'password' => password_hash('maria123', PASSWORD_DEFAULT), 'mail' => 'maria@example.com'],
    ['nombre' => 'Pedro', 'password' => password_hash('pedro123', PASSWORD_DEFAULT), 'mail' => 'pedro@example.com'],
    ['nombre' => 'Ana', 'password' => password_hash('ana123', PASSWORD_DEFAULT), 'mail' => 'ana@example.com']
];

$juegos = [
    [
        'titulo' => 'The Witcher 3',
        'descripcion' => 'Juego de rol de mundo abierto donde encarnas a Geralt de Rivia, un cazador de monstruos profesional en busca de su hija adoptiva.',
        'autor' => 'CD Projekt Red',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/292030/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://www.thewitcher.com/es',
        'anio' => 2015
    ],
    [
        'titulo' => 'Red Dead Redemption 2',
        'descripcion' => 'Epopeya de acción y aventuras ambientada en los albores de la era moderna. Sigue la historia de Arthur Morgan y la banda de Dutch van der Linde.',
        'autor' => 'Rockstar Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1174180/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.rockstargames.com/reddeadredemption2',
        'anio' => 2018
    ],
    [
        'titulo' => 'Cyberpunk 2077',
        'descripcion' => 'RPG de acción y aventura de mundo abierto que se desarrolla en Night City, una megalópolis obsesionada con el poder, el glamur y las modificaciones corporales.',
        'autor' => 'CD Projekt Red',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://www.cyberpunk.net',
        'anio' => 2020
    ],
    [
        'titulo' => 'Elden Ring',
        'descripcion' => 'Nuevo juego de rol de acción y fantasía desarrollado por FromSoftware y producido por Hidetaka Miyazaki en colaboración con George R.R. Martin.',
        'autor' => 'FromSoftware',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1245620/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://en.bandainamcoent.eu/elden-ring',
        'anio' => 2022
    ],
    [
        'titulo' => 'Minecraft',
        'descripcion' => 'Juego de construcción y aventuras en un mundo generado proceduralmente hecho de bloques. Explora, construye y sobrevive.',
        'autor' => 'Mojang Studios',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1794680/header.jpg',
        'categoria' => 'Sandbox',
        'url' => 'https://www.minecraft.net',
        'anio' => 2011
    ],
    [
        'titulo' => 'God of War',
        'descripcion' => 'Kratos y su hijo Atreus se embarcan en un viaje épico por los reinos nórdicos. Una historia profunda de padre e hijo en un mundo mitológico brutal.',
        'autor' => 'Santa Monica Studio',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1593500/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.playstation.com/games/god-of-war',
        'anio' => 2018
    ],
    [
        'titulo' => 'Horizon Zero Dawn',
        'descripcion' => 'Aventura de acción en un mundo post-apocalíptico dominado por máquinas. Sigue a Aloy en su búsqueda de respuestas sobre su pasado.',
        'autor' => 'Guerrilla Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1151640/header.jpg',
        'categoria' => 'Aventura',
        'url' => 'https://www.playstation.com/games/horizon-zero-dawn',
        'anio' => 2017
    ],
    [
        'titulo' => 'Dark Souls III',
        'descripcion' => 'El aclamado juego de rol de acción conocido por su dificultad implacable. Explora un mundo oscuro lleno de enemigos mortales y jefes épicos.',
        'autor' => 'FromSoftware',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/374320/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://www.darksouls3.com',
        'anio' => 2016
    ],
    [
        'titulo' => 'Sekiro: Shadows Die Twice',
        'descripcion' => 'Juego de acción y aventura en el Japón del período Sengoku. Combate preciso y desafiante con un sistema de combate único.',
        'autor' => 'FromSoftware',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/814380/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.sekirothegame.com',
        'anio' => 2019
    ],
    [
        'titulo' => 'The Last of Us Part II',
        'descripcion' => 'Continuación de la historia de Ellie en un mundo post-apocalíptico. Una narrativa intensa y emotiva sobre venganza y redención.',
        'autor' => 'Naughty Dog',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1888930/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.playstation.com/games/the-last-of-us-part-ii',
        'anio' => 2020
    ],
    [
        'titulo' => 'Spider-Man',
        'descripcion' => 'Juego de acción en mundo abierto protagonizado por Spider-Man. Balancea por Nueva York mientras combates el crimen y resuelves una conspiración.',
        'autor' => 'Insomniac Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1817070/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.playstation.com/games/marvels-spider-man',
        'anio' => 2018
    ],
    [
        'titulo' => 'Hollow Knight',
        'descripcion' => 'Aventura de acción en 2D ambientada en Hallownest, un vasto reino subterráneo en ruinas. Exploración metroidvania con combates desafiantes.',
        'autor' => 'Team Cherry',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/367520/header.jpg',
        'categoria' => 'Aventura',
        'url' => 'https://www.hollowknight.com',
        'anio' => 2017
    ],
    [
        'titulo' => 'Hades',
        'descripcion' => 'Roguelike de acción con elementos de dungeon crawler. Escapa del inframundo griego con la ayuda de los dioses del Olimpo.',
        'autor' => 'Supergiant Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1145360/header.jpg',
        'categoria' => 'Roguelike',
        'url' => 'https://www.supergiantgames.com/games/hades',
        'anio' => 2020
    ],
    [
        'titulo' => 'Stardew Valley',
        'descripcion' => 'Juego de simulación de granja con elementos de RPG. Cultiva tu tierra, cría animales, explora cavernas y construye relaciones con los habitantes.',
        'autor' => 'ConcernedApe',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/413150/header.jpg',
        'categoria' => 'Simulacion',
        'url' => 'https://www.stardewvalley.net',
        'anio' => 2016
    ],
    [
        'titulo' => 'Celeste',
        'descripcion' => 'Plataformas desafiante sobre escalar una montaña. Una historia conmovedora sobre superar obstáculos internos y externos.',
        'autor' => 'Maddy Makes Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/504230/header.jpg',
        'categoria' => 'Plataformas',
        'url' => 'http://www.celestegame.com',
        'anio' => 2018
    ],
    [
        'titulo' => 'Death Stranding',
        'descripcion' => 'Experiencia única de exploración y conexión. Reconecta una América fragmentada entregando paquetes a través de terrenos hostiles.',
        'autor' => 'Kojima Productions',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1190460/header.jpg',
        'categoria' => 'Aventura',
        'url' => 'https://www.kojimaproductions.jp/en/death-stranding.html',
        'anio' => 2019
    ],
    [
        'titulo' => 'Bloodborne',
        'descripcion' => 'RPG de acción ambientado en la ciudad gótica de Yharnam. Combate rápido y agresivo contra horrores cósmicos.',
        'autor' => 'FromSoftware',
        'caratula' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2622080/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://www.playstation.com/games/bloodborne',
        'anio' => 2015
    ],
    [
        'titulo' => 'Ghost of Tsushima',
        'descripcion' => 'Aventura de acción en mundo abierto ambientada en el Japón feudal. Conviértete en el Fantasma y libera la isla de Tsushima de los invasores mongoles.',
        'autor' => 'Sucker Punch Productions',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/2215430/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.playstation.com/games/ghost-of-tsushima',
        'anio' => 2020
    ],
    [
        'titulo' => 'It Takes Two',
        'descripcion' => 'Aventura cooperativa exclusiva que narra la historia de Cody y May, una pareja transformada en muñecos por un hechizo mágico.',
        'autor' => 'Hazelight Studios',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1426210/header.jpg',
        'categoria' => 'Aventura',
        'url' => 'https://www.ea.com/games/it-takes-two',
        'anio' => 2021
    ],
    [
        'titulo' => 'Resident Evil Village',
        'descripcion' => 'Survival horror en primera persona. Ethan Winters busca a su hija en un misterioso pueblo europeo lleno de horrores.',
        'autor' => 'Capcom',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1196590/header.jpg',
        'categoria' => 'Terror',
        'url' => 'https://www.residentevil.com/village',
        'anio' => 2021
    ],
    [
        'titulo' => 'Doom Eternal',
        'descripcion' => 'Shooter frenético en primera persona. Como el Doom Slayer, lucha contra demonios en la Tierra y más allá con un arsenal devastador.',
        'autor' => 'id Software',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/782330/header.jpg',
        'categoria' => 'Shooter',
        'url' => 'https://bethesda.net/game/doom',
        'anio' => 2020
    ],
    [
        'titulo' => 'Control',
        'descripcion' => 'Aventura de acción sobrenatural en tercera persona. Investiga fenómenos paranormales en el misterioso Oldest House.',
        'autor' => 'Remedy Entertainment',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/870780/header.jpg',
        'categoria' => 'Accion',
        'url' => 'https://www.remedygames.com/games/control',
        'anio' => 2019
    ],
    [
        'titulo' => 'Portal 2',
        'descripcion' => 'Juego de puzzles en primera persona. Usa el dispositivo de portales para resolver acertijos imposibles en Aperture Science.',
        'autor' => 'Valve',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/620/header.jpg',
        'categoria' => 'Puzzle',
        'url' => 'https://www.thinkwithportals.com',
        'anio' => 2011
    ],
    [
        'titulo' => 'Bioshock Infinite',
        'descripcion' => 'Shooter en primera persona ambientado en la ciudad flotante de Columbia en 1912. Una historia profunda sobre dimensiones alternas y elecciones.',
        'autor' => '2K Games',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/8870/header.jpg',
        'categoria' => 'Shooter',
        'url' => 'https://2k.com/bioshock',
        'anio' => 2013
    ],
    [
        'titulo' => 'Fall Guys',
        'descripcion' => 'Battle royale multijugador con mini-juegos caóticos. Compite con hasta 60 jugadores en divertidos obstáculos hasta ser el último en pie.',
        'autor' => 'Mediatonic',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1097150/header.jpg',
        'categoria' => 'Multijugador',
        'url' => 'https://www.fallguys.com',
        'anio' => 2020
    ],
    [
        'titulo' => 'Among Us',
        'descripcion' => 'Juego social multijugador de deducción. Trabaja en equipo para completar tareas o elimina a la tripulación como impostor.',
        'autor' => 'InnerSloth',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/945360/header.jpg',
        'categoria' => 'Multijugador',
        'url' => 'https://www.innersloth.com/games/among-us',
        'anio' => 2018
    ],
    [
        'titulo' => 'Undertale',
        'descripcion' => 'RPG indie donde la amabilidad importa tanto como la fuerza. Cada decisión afecta el destino de los monstruos subterráneos.',
        'autor' => 'Toby Fox',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/391540/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://undertale.com',
        'anio' => 2015
    ],
    [
        'titulo' => 'Ori and the Will of the Wisps',
        'descripcion' => 'Plataformas metroidvania con arte visual impresionante. Una historia emotiva sobre familia, sacrificio y esperanza.',
        'autor' => 'Moon Studios',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1057090/header.jpg',
        'categoria' => 'Plataformas',
        'url' => 'https://www.orithegame.com',
        'anio' => 2020
    ],
    [
        'titulo' => 'Disco Elysium',
        'descripcion' => 'RPG revolucionario centrado en la narrativa. Investiga un asesinato en un mundo único mientras descubres quién eres.',
        'autor' => 'ZA/UM',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/632470/header.jpg',
        'categoria' => 'RPG',
        'url' => 'https://discoelysium.com',
        'anio' => 2019
    ],
    [
        'titulo' => 'Valheim',
        'descripcion' => 'Juego de supervivencia y exploración inspirado en la mitología nórdica. Construye, explora y conquista el décimo mundo.',
        'autor' => 'Iron Gate Studio',
        'caratula' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/892970/header.jpg',
        'categoria' => 'Supervivencia',
        'url' => 'https://www.valheimgame.com',
        'anio' => 2021
    ]
];

try {
    echo "<h2>Insertando usuarios...</h2>";
    $stmt = $conn->prepare("INSERT INTO users (Nombre, password, mail) VALUES (:nombre, :password, :mail)");
    
    foreach ($usuarios as $usuario) {
        try {
            $stmt->execute([
                ':nombre' => $usuario['nombre'],
                ':password' => $usuario['password'],
                ':mail' => $usuario['mail']
            ]);
            echo "✓ Usuario '{$usuario['nombre']}' insertado correctamente<br>";
        } catch (PDOException $e) {
            echo "✗ Error al insertar usuario '{$usuario['nombre']}': " . $e->getMessage() . "<br>";
        }
    }
    
    echo "<br><h2>Obteniendo IDs de usuarios...</h2>";
    $stmt = $conn->query("SELECT id FROM users ORDER BY id");
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "IDs disponibles: " . implode(', ', $userIds) . "<br><br>";
    
    echo "<h2>Insertando juegos...</h2>";
    $stmt = $conn->prepare("INSERT INTO bibliotecajuegos (user_id, titulo, descripcion, autor, caratula, categoria, url, anio) 
                           VALUES (:user_id, :titulo, :descripcion, :autor, :caratula, :categoria, :url, :anio)");
    
    $juegoCount = 0;
    foreach ($juegos as $juego) {
        $randomUserId = $userIds[array_rand($userIds)];
        
        try {
            $stmt->execute([
                ':user_id' => $randomUserId,
                ':titulo' => $juego['titulo'],
                ':descripcion' => $juego['descripcion'],
                ':autor' => $juego['autor'],
                ':caratula' => $juego['caratula'],
                ':categoria' => $juego['categoria'],
                ':url' => $juego['url'],
                ':anio' => $juego['anio']
            ]);
            $juegoCount++;
            echo "✓ Juego '{$juego['titulo']}' insertado (Usuario ID: {$randomUserId})<br>";
        } catch (PDOException $e) {
            echo "✗ Error al insertar juego '{$juego['titulo']}': " . $e->getMessage() . "<br>";
        }
    }
    
    echo "<br><h2>Resumen:</h2>";
    echo "Total de juegos insertados: {$juegoCount}/30<br>";
    echo "<br><a href='/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php'>Ver Biblioteca de Juegos</a>";
    
} catch (PDOException $e) {
    echo "Error general: " . $e->getMessage();
}
?>
