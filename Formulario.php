<!DOCTYPE html>
<html>
<?php
session_start();
require("Conexion.php");
$Error;
$copia;
try {
    //Preparar SQL
    $stmt = $conn->prepare("INSERT INTO users (Nombre,password,mail) VALUES (:nombre, :contrasena, :email)");
    $stmt->bindParam(':nombre',$nombre);
    $stmt->bindParam(':contrasena',$contraseña);
    $stmt->bindParam(':email',$mail);
    
    //Poner nombres
    if(isset($_POST["nombre"])&&$_POST["nombre"]!=''){
    $nombre=$_POST["nombre"];
    }else $Error=$Error."Nombre vacio";
    if(filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        $mail=$_POST["email"];
    }else $Error=$Error. " Mail No Valido";
    
    if($_POST["contraseña"]==$_POST["CorfirmaContraseña"]){
        $copia=$_POST["contraseña"];
        $contraseña= password_hash($_POST["contraseña"],PASSWORD_DEFAULT);
    }else $Error=$Error." Contraseña incorrecta";
    $stmt->execute();

    echo "Insert completado";
} catch (PDOException $e) {
    $_SESSION["Error"]=$Error;
    $_SESSION["nombre"]=$nombre;
    $_SESSION["contraseña"]=$copia;
    $_SESSION["mail"]=$mail;
    header("Location: Registro.php");
    die;
}
    
    if ($mail!=null) {
        $_SESSION["Log"]=$mail;
        $_SESSION["Usuario"]=$nombre;
        header("Location: Session.php");
    }
    

$conn=null;
?>
</html>