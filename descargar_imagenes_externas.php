<?php
require_once __DIR__ . '/Conexion.php';

$carpetaCaratulas = __DIR__ . DIRECTORY_SEPARATOR . 'caratulas';

if (!is_dir($carpetaCaratulas)) {
    mkdir($carpetaCaratulas, 0755, true);
}

function descargarImagen($url, $carpeta) {
    $contenido = @file_get_contents($url, false, stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]
    ]));
    
    if ($contenido === false) {
        return null;
    }
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($contenido);
    
    $extensiones = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];
    
    if (!isset($extensiones[$mimeType])) {
        return null;
    }
    
    $ext = $extensiones[$mimeType];
    $hash = hash("sha256", $contenido);
    $nuevoNombre = $hash . "." . $ext;
    $destino = $carpeta . DIRECTORY_SEPARATOR . $nuevoNombre;
    
    $intentos = 0;
    while (file_exists($destino) && $intentos < 5) {
        $archivoExistente = file_get_contents($destino);
        if (hash("sha256", $archivoExistente) === $hash) {
            return 'caratulas/' . $nuevoNombre;
        }
        $sufijo = substr(bin2hex(random_bytes(4)), 0, 6);
        $nuevoNombre = $hash . "_" . $sufijo . "." . $ext;
        $destino = $carpeta . DIRECTORY_SEPARATOR . $nuevoNombre;
        $intentos++;
    }
    
    if (file_put_contents($destino, $contenido)) {
        return 'caratulas/' . $nuevoNombre;
    }
    
    return null;
}

try {
    $stmt = $conn->query("SELECT id, titulo, caratula FROM bibliotecajuegos WHERE caratula LIKE 'http%'");
    $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($juegos)) {
        echo "<h2>No se encontraron juegos con imágenes externas</h2>";
        echo "<a href='/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php'>Volver a la biblioteca</a>";
        exit;
    }
    
    echo "<h2>Descargando imágenes externas...</h2>";
    echo "<p>Total de juegos a procesar: " . count($juegos) . "</p><br>";
    
    $urlsCorrectas = [
        'Bloodborne' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2622080/header.jpg',
        'The Last of Us Part II' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/1888930/header.jpg'
    ];
    
    $stmtUpdate = $conn->prepare("UPDATE bibliotecajuegos SET caratula = :nueva_ruta WHERE id = :id");
    
    $exitosos = 0;
    $fallidos = 0;
    
    foreach ($juegos as $juego) {
        echo "Procesando: <strong>{$juego['titulo']}</strong>...<br>";
        
        $urlDescarga = $juego['caratula'];
        
        if (isset($urlsCorrectas[$juego['titulo']])) {
            $urlDescarga = $urlsCorrectas[$juego['titulo']];
            echo "URL corregida detectada para '{$juego['titulo']}'<br>";
        }
        
        echo "URL a descargar: {$urlDescarga}<br>";
        
        $nuevaRuta = descargarImagen($urlDescarga, $carpetaCaratulas);
        
        if ($nuevaRuta !== null) {
            $stmtUpdate->execute([
                ':nueva_ruta' => $nuevaRuta,
                ':id' => $juego['id']
            ]);
            echo "✓ Imagen descargada y guardada como: {$nuevaRuta}<br>";
            echo "✓ Base de datos actualizada<br>";
            $exitosos++;
        } else {
            echo "✗ Error al descargar la imagen<br>";
            $fallidos++;
        }
        
        echo "<hr>";
        flush();
        ob_flush();
    }
    
    echo "<br><h2>Resumen:</h2>";
    echo "Imágenes descargadas exitosamente: <strong>{$exitosos}</strong><br>";
    echo "Fallos: <strong>{$fallidos}</strong><br>";
    echo "<br><a href='/ActividadEvaluable1PHP/BibliotecaDeJuegos/VerJuegos.php'>Ver Biblioteca de Juegos</a>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
