<?php
session_start();

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
        $tipo_usuario = $user['tipo_usuario'];
        // Verificar la contraseña
        if ($_POST["password"] == $user["password"]) {
            
            // Establecer la variable de sesión de inicio de sesión como verdadera
            $_SESSION["loginok"] = true;
            
            // Redireccionar según el tipo de usuario
            if ($tipo_usuario == "administrador") {
                $_SESSION["loginadmin"] = true;
                header("Location: ../view/tablas.php?tabla=alumnos");
                exit;
            } elseif ($tipo_usuario == "profesor") {
                $_SESSION["loginprofe"] = true;
                header("Location: ../view/tablas.php?tabla=alumnos");
                exit;
            } elseif ($tipo_usuario == "alumno") {
                $_SESSION["loginalum"] = true;
                header("Location: ../view/tablas.php?tabla=alumnos");
                exit;
            } 
        }
    }
}
    
// Si las credenciales son incorrectas
header("Location: ../view/login.php?error=1");
exit;
?>
