<?php

$host = "localhost";
$dbname = "proyecto_escuela";
$username = "root";
$password = "qazQAZ123";

try {
    // Corregimos la cadena de conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuramos PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    // Si hay un error, mostramos un mensaje
    echo "Error de conexión: " . $e->getMessage();
    // Detenemos la ejecución del script
    exit();
}
return $pdo;
?>
