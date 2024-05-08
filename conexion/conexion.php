<?php
$host = "localhost";
$nombreBD = "proyectoescuela";
$userBD = "root";
$passBD = "";
try{
    $con = new PDO("mysql:host=$host; dbname=$nombreBD", $userBD, $passBD);
}catch(PDOException $e){
    echo "Error de conexión con la base de datos:".$e->getMessage();
}
$con->query("USE ");
$mysql = $con->prepare("SELECT * FROM ");
$mysql->execute();
$resultado = $mysql->fetchAll();
?>