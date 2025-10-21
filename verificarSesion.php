<?php
function verificarSesion() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    
    if (isset($_SESSION["Usuario"])) {
        return true;
    }
    
    if (isset($_COOKIE["remember_token"]) && isset($_COOKIE["remember_user"])) {
        require_once __DIR__ . "/Conexion.php";
        
        $token = $_COOKIE["remember_token"];
        $userId = (int)$_COOKIE["remember_user"];
        $hashedToken = hash("sha256", $token);
        
        try {
            $stmt = $conn->prepare("
                SELECT id, Nombre, mail, remember_expiry 
                FROM users 
                WHERE id = :id AND remember_token = :token 
                AND remember_expiry > NOW() 
                LIMIT 1
            ");
            $stmt->execute([":id" => $userId, ":token" => $hashedToken]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $_SESSION["Log"] = $user["mail"];
                $_SESSION["Usuario"] = $user["Nombre"];
                $_SESSION["user_id"] = $user["id"];
                return true;
            } else {
                setcookie("remember_token", "", time() - 3600, "/");
                setcookie("remember_user", "", time() - 3600, "/");
            }
        } catch (PDOException $e) {
            error_log("Error verificando cookie de sesión: " . $e->getMessage());
        }
    }
    
    return false;
}

function cerrarSesionCompleta() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    
    if (isset($_COOKIE["remember_token"]) && isset($_COOKIE["remember_user"])) {
        require_once __DIR__ . "/Conexion.php";
        
        $userId = (int)$_COOKIE["remember_user"];
        
        try {
            $stmt = $conn->prepare("UPDATE users SET remember_token = NULL, remember_expiry = NULL WHERE id = :id");
            $stmt->execute([":id" => $userId]);
        } catch (PDOException $e) {
            error_log("Error limpiando token de sesión: " . $e->getMessage());
        }
        
        setcookie("remember_token", "", time() - 3600, "/");
        setcookie("remember_user", "", time() - 3600, "/");
    }
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), "", time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}
?>