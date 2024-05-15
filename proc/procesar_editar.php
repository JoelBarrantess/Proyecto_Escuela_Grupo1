<?php
require_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_alumno = $_POST['id_alumno'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $clase = $_POST['clase'];

    // Preparar y ejecutar la consulta para actualizar los datos del alumno
    $consulta = $pdo->prepare('UPDATE tbl_alumno SET nom_alu = :nombre, apellido1_alu = :apellido1, apellido2_alu = :apellido2, dni_alum = :dni, email_alum = :email, telf_alum = :telefono, id_clase = :clase WHERE id_alumno = :id_alumno');
    $consulta->execute([
        'nombre' => $nombre,
        'apellido1' => $apellido1,
        'apellido2' => $apellido2,
        'dni' => $dni,
        'email' => $email,
        'telefono' => $telefono,
        'clase' => $clase,
        'id_alumno' => $id_alumno
    ]);

    // Redirigir de vuelta a la pagina de las tablas
    header('Location: ../view/tablas.php?tabla=alumnos');
}
?>
