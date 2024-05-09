<?php
$host = "localhost";
$nombreBD = "proyecto_escuela";
$userBD = "root";
$passBD = "";
try{
    $con = new PDO("mysql:host=$host; dbname=$nombreBD", $userBD, $passBD);
}catch(PDOException $e){
    echo "Error de conexión con la base de datos:".$e->getMessage();
}
$con->query("USE proyecto_escuela");
$mysql = $con->prepare("SELECT * FROM tbl_alumno");
$mysql->execute();
$resultado = $mysql->fetchAll();
?>