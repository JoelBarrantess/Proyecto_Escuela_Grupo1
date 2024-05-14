<?php
require_once '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $clase = $_POST['clase'];

    // Preparar y ejecutar la consulta para insertar el nuevo alumno
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

    // Redirigir de vuelta a la página principal o a otra página
    header('Location: ../view/tablas.php');
}
?>
