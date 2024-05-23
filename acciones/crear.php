<?php
require_once '../conexion/conexion.php';

//Recogemos los datos enviados por el formulario de crear
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $clase = isset($_POST['clase']) ? $_POST['clase'] : null;

    try {
        if ($tipo_usuario == 'alumno') {
            // Prepararamos y ejecutamos la consulta para insertar el nuevo alumno
            $consulta = $pdo->prepare('INSERT INTO tbl_alumno (nom_alu, apellido1_alu, apellido2_alu, dni_alum, email_alum, telf_alum, id_clase) VALUES (:nombre, :apellido1, :apellido2, :dni, :email, :telefono, :clase)');
            $consulta->execute([
                'nombre' => $nombre,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'dni' => $dni,
                'email' => $email,
                'telefono' => $telefono,
                'clase' => $clase
            ]);
        } elseif ($tipo_usuario == 'profesor') {
            // Preparamos y ejecutamos la consulta para insertar el nuevo profesor
            $consulta = $pdo->prepare('INSERT INTO tbl_profesor (nom_prof, apellido1_prof, apellido2_prof, dni_prof, email_prof, telf_prof) VALUES (:nombre, :apellido1, :apellido2, :dni, :email, :telefono)');
            $consulta->execute([
                'nombre' => $nombre,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'dni' => $dni,
                'email' => $email,
                'telefono' => $telefono
            ]);
        }

        // Redirigir de vuelta a la página de las tablas
        header('Location: ../view/tablas.php?tabla=' . ($tipo_usuario == 'alumno' ? 'alumnos' : 'profesores'));
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>


