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
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(isset($username) && $username == "subemelaradio" ){
       session_start();
        $_SESSION['NOMBREOK'] = $username;
        if (isset($password) && $password == "traemeelalcohol" ) {

        }
    } elseif (isset($username) && $username != "subemelaradio" ) {
        header("location: ../view/login.php?error=1"); 
    }
    ?>

</body>
</html>