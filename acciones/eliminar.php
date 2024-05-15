<?php
require_once '../conexion/conexion.php';

// Verificar si se recibió una solicitud GET para eliminar
if(isset($_GET['id_alumno']) || isset($_GET['id_profesor'])) {
    // Determinar si se está eliminando un alumno o un profesor
    if (isset($_GET['id_alumno'])) {
        $idEliminar = $_GET['id_alumno'];
        $tabla = 'tbl_alumno';
    } elseif (isset($_GET['id_profesor'])) {
        $idEliminar = $_GET['id_profesor'];
        $tabla = 'tbl_profesor';
    }

    try {
        // Preparar y ejecutar la consulta para eliminar el registro
        $sql = "DELETE FROM $tabla WHERE id_" . ($tabla == 'tbl_alumno' ? 'alumno' : 'profesor') . " = :idEliminar";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEliminar', $idEliminar);
        $stmt->execute();

        // Redireccionar a la página principal después de eliminar
        header('Location: ../view/tablas.php?tabla=alumnos');
        exit(); // Terminar el script después de redirigir
    } catch(PDOException $e) {
        // En caso de error, mostrar el mensaje de error
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
} else {
    // Si no se recibió ningún ID, redireccionar a la página principal
    header('Location: ../view/tablas.php?tabla=alumnos');
    exit();
}
?>
