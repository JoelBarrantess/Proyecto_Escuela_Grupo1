<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link css -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Script javascript -->
    <script src="../js/scripts.js"></script>
</head>
<body>
<?php
    require_once("../conexion/conexion.php");
?>
  
<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $consulta = "select * from login where username='$username' and password='$password'";
    $resultado = mysqli_query($con, $consulta);
    $contador = mysqli_num_rows($resultado);
    if ($contador > 0 ) {
        header("location: ../view/tablas.php");
    }
?>


<?php
    if(isset($username) && $username == "admin" ){
       
        if (isset($password) && $password == "qazQAZ123" ) {
            session_start();
            $_SESSION['USERNAMEOK'] = $username;
            $_SESSION['PASSWORDOK'] = $password;
            header("location: ../view/tablas.php");
        } elseif (isset($password) && $username != "qazQAZ123" ) {
            header("location: ../view/login.php?error=2");
        }
    } elseif (isset($username) && $username != "admin" ) {
        header("location: ../view/login.php?error=1"); 
    }
?>
    

</body>
</html>