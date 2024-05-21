<?php
session_start();
if (!isset($_SESSION['loginok'])) {
    header("location: ./login.php?error=2");
    exit;
}

require_once '../conexion/conexion.php';

try {
    // Obtener el nombre de la tabla desde un parámetro GET
    $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : 'tbl_alumno';
    
    // Establecer la codificación de caracteres a UTF-8
    $pdo->exec("SET NAMES utf8");

    if ($tabla == 'profesores') {
        // Obtener registros de la tabla tbl_profesor
        $query = $pdo->query("SELECT * FROM tbl_profesor ORDER BY id_profesor ASC");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($resultados) > 0) {
            $delimiter = ",";
            $filename = "profesores_" . date('Y-m-d') . ".csv";
            
            // Crear un puntero de archivo
            $f = fopen('php://memory', 'w');
            
            // Establecer encabezados de columna para tbl_profesor
            $fields = array('ID', 'Nombre', 'Apellido 1', 'Apellido 2', 'DNI', 'Email', 'Teléfono');
            fputcsv($f, $fields, $delimiter);
            
            // Salida de cada fila de datos, formatear línea como CSV y escribir en el puntero de archivo
            foreach ($resultados as $row) {
                $lineData = array(
                    $row['id_profesor'],
                    $row['nom_prof'],
                    $row['apellido1_prof'],
                    $row['apellido2_prof'],
                    $row['dni_prof'],
                    $row['email_prof'],
                    $row['telf_prof']
                );
                fputcsv($f, $lineData, $delimiter);
            }
            
            // Volver al principio del archivo
            fseek($f, 0);
            
            // Establecer encabezados para descargar el archivo en lugar de mostrarlo
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            
            // Salida de todos los datos restantes en un puntero de archivo
            fpassthru($f);
        } else {
            echo "No hay registros en la base de datos de profesores.";
        }
    } else {
        // Obtener registros de la tabla tbl_alumno
        $query = $pdo->query("SELECT * FROM tbl_alumno ORDER BY id_alumno ASC");
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($resultados) > 0) {
            $delimiter = ",";
            $filename = "alumnos_" . date('Y-m-d') . ".csv";
            
            // Crear un puntero de archivo
            $f = fopen('php://memory', 'w');
            
            // Establecer encabezados de columna para tbl_alumno
            $fields = array('ID', 'Nombre', 'Apellido 1', 'Apellido 2', 'DNI', 'Email', 'Teléfono', 'ID Clase');
            fputcsv($f, $fields, $delimiter);
            
            // Salida de cada fila de datos, formatear línea como CSV y escribir en el puntero de archivo
            foreach ($resultados as $row) {
                $lineData = array(
                    $row['id_alumno'],
                    $row['nom_alu'],
                    $row['apellido1_alu'],
                    $row['apellido2_alu'],
                    $row['dni_alum'],
                    $row['email_alum'],
                    $row['telf_alum'],
                    $row['id_clase']
                );
                fputcsv($f, $lineData, $delimiter);
            }
            
            // Volver al principio del archivo
            fseek($f, 0);
            
            // Establecer encabezados para descargar el archivo en lugar de mostrarlo
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            
            // Salida de todos los datos restantes en un puntero de archivo
            fpassthru($f);
        } else {
            echo "No hay registros en la base de datos de alumnos.";
        }
    }
} catch (PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
}

// Terminar la ejecución del script
exit;
?>
