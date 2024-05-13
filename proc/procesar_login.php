<?php

$login = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Incluir el archivo de conexión
    require_once "../conexion/conexion.php";
    
    // Preparar la consulta SQL para evitar inyecciones SQL
    $sql = "SELECT * FROM tbl_login WHERE username = :username";
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $_POST["username"]);
    $stmt->execute();
    
    // Obtener el resultado
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Verificar la contraseña
        if ($_POST["password"] == $user["password"]) {
            
            session_start();
            $_SESSION["loginok"] = $login;
            header("Location: ../view/tablas.php");
            exit;
        }
    }
    
    header("Location: ../view/login.php?error=1");
    exit;
}
?>
