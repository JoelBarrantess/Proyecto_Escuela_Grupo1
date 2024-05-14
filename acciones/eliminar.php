<?php
require_once '../conexion/conexion.php';
echo $_GET['id_alumno'];
// Verificar si se recibió una solicitud POST para eliminar
if(isset($_GET['id_alumno'])){
    // Obtener el id del registro a eliminar
    $idEliminar = $_GET['id_alumno'];
    echo $_GET['id_alumno'];
    try {
        // Preparar y ejecutar la consulta para eliminar el registro
        $sql = "DELETE FROM tbl_alumno WHERE id_alumno = :idEliminar";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEliminar', $idEliminar);
        $stmt->execute();

        // Redireccionar a la página principal después de eliminar
        header('Location: ../view/tablas.php');
        exit(); // Terminar el script después de redirigir
    } catch(PDOException $e) {
        // En caso de error, mostrar el mensaje de error
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
}
?>
?>