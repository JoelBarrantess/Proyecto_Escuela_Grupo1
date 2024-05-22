<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Incluir el archivo de conexión
    require_once "../conexion/conexion.php";

    try {
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
                    $_SESSION["id_profesor"] = $user['id_profesor']; // Almacenar id_profesor en la sesión
                    header("Location: ../view/tablas.php?tabla=alumnos");
                    exit;
                } elseif ($tipo_usuario == "alumno") {
                    $_SESSION["loginalum"] = true;
                    header("Location: ../view/alumnos.php");
                    exit;
                } 
            } else {
                // Contraseña incorrecta
                error_log("Contraseña incorrecta para el usuario: " . $_POST["username"]);
                header("Location: ../view/login.php?error=1");
                exit;
            }
        } else {
            // Usuario no encontrado
            error_log("Usuario no encontrado: " . $_POST["username"]);
            header("Location: ../view/login.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        // Error en la consulta SQL o en la conexión
        error_log("Error en la consulta SQL: " . $e->getMessage());
        header("Location: ../view/login.php?error=1");
        exit;
    }
} else {
    // Método de solicitud no permitido
    header("Location: ../view/login.php?error=1");
    exit;
}
?>
