<?php
session_start();
if (!isset($_SESSION['loginok'])) {
    header("location: ./login.php?error=2");
    exit;
}

require_once '../conexion/conexion.php';

try {
    // Obtener el nombre de la tabla desde un parámetro GET y validarlo
    $allowed_tables = ['tbl_profesor', 'tbl_alumno'];
    $tabla = in_array($_GET['tabla'], $allowed_tables) ? $_GET['tabla'] : 'tbl_alumno';
    
    // Establecer la codificación de caracteres a UTF-8
    $pdo->exec("SET NAMES utf8");

    // Construir el nombre del archivo basado en la tabla
    $filename = ($tabla == 'tbl_profesor' ? 'profesores_' : 'alumnos_') . date('Y-m-d') . '.csv';
    $delimiter = ",";

    // Consultar la base de datos
    $query = $pdo->query("SELECT * FROM $tabla ORDER BY id_" . ($tabla == 'tbl_profesor' ? 'profesor' : 'alumno') . " ASC");
    $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultados) > 0) {
        $f = fopen('php://memory', 'w');

        // Obtener los nombres de las columnas
        $columnNames = array_keys($resultados[0]);
        fputcsv($f, $columnNames, $delimiter);

        // Salida de cada fila de datos, formatear línea como CSV y escribir en el puntero de archivo
        foreach ($resultados as $row) {
            fputcsv($f, $row, $delimiter);
        }
        
        // Volver al principio del archivo
        fseek($f, 0);
        
        // Establecer encabezados para descargar el archivo en lugar de mostrarlo
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        // Salida de todos los datos restantes en un puntero de archivo
        fpassthru($f);
    } else {
        echo "No hay registros en la base de datos de " . ($tabla == 'tbl_profesor' ? 'profesores' : 'alumnos') . ".";
    }
} catch (PDOException $e) {
    echo "Error al obtener los datos: " . $e->getMessage();
}

// Terminar la ejecución del script
exit;
?>
