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

    // Redirigir de vuelta a la pagina de las tablas
    header('Location: ../view/tablas.php');
    exit();
}
