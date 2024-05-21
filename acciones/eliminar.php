<?php
require_once '../conexion/conexion.php';

if (isset($_GET['id_alumno']) || isset($_GET['id_profesor'])) {
    if (isset($_GET['id_alumno'])) {
        $idEliminar = $_GET['id_alumno'];
        $tabla = 'tbl_alumno';
    } elseif (isset($_GET['id_profesor'])) {
        $idEliminar = $_GET['id_profesor'];
        $tabla = 'tbl_profesor';
    }

    try {
        $sql = "DELETE FROM $tabla WHERE id_" . ($tabla == 'tbl_alumno' ? 'alumno' : 'profesor') . " = :idEliminar";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEliminar', $idEliminar);
        $stmt->execute();

        header('Location: ../view/tablas.php?tabla=' . ($tabla == 'tbl_alumno' ? 'alumnos' : 'profesores'));
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
} else {
    header('Location: ../view/tablas.php?tabla=alumnos');
    exit();
}
?>

