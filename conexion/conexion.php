<?php
$host = "localhost";
$nombreBD = "prueba_escuelas";
$userBD = "root";
$passBD = "";
try{
    $con = mysqli_connect("mysql:host=$host; dbname=$nombreBD", $userBD, $passBD);
}catch(Exception $e){
    echo "Error de conexión con la base de datos:".$e->getMessage();
}
?>