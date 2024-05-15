<?php
require_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id = $_POST['id'];
    $tabla = $_POST['tabla'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $clase = isset($_POST['clase']) ? $_POST['clase'] : null;

    // Validar y sanitizar las entradas
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $tabla = filter_var($tabla, FILTER_SANITIZE_STRING);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
    $apellido1 = filter_var($apellido1, FILTER_SANITIZE_STRING);
    $apellido2 = filter_var($apellido2, FILTER_SANITIZE_STRING);
    $dni = filter_var($dni, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
    if ($clase !== null) {
        $clase = filter_var($clase, FILTER_SANITIZE_NUMBER_INT);
    }

    try {
        // Preparar y ejecutar la consulta para actualizar los datos
        if ($tabla == 'alumnos') {
            $consulta = $pdo->prepare('UPDATE tbl_alumno SET nom_alu = :nombre, apellido1_alu = :apellido1, apellido2_alu = :apellido2, dni_alum = :dni, email_alum = :email, telf_alum = :telefono, id_clase = :clase WHERE id_alumno = :id');
            $consulta->execute([
                'nombre' => $nombre,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'dni' => $dni,
                'email' => $email,
                'telefono' => $telefono,
                'clase' => $clase,
                'id' => $id
            ]);
        } elseif ($tabla == 'profesores') {
            $consulta = $pdo->prepare('UPDATE tbl_profesor SET nom_prof = :nombre, apellido1_prof = :apellido1, apellido2_prof = :apellido2, dni_prof = :dni, email_prof = :email, telf_prof = :telefono WHERE id_profesor = :id');
            $consulta->execute([
                'nombre' => $nombre,
                'apellido1' => $apellido1,
                'apellido2' => $apellido2,
                'dni' => $dni,
                'email' => $email,
                'telefono' => $telefono,
                'id' => $id
            ]);
        }

        // Redirigir de vuelta a la página de las tablas según la tabla modificada
        header('Location: ../view/tablas.php?tabla=' . $tabla);
        exit();
    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        echo 'Error: ' . $e->getMessage();
    }
}
?>
