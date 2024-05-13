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
<body class="login-body">
    <form action="../proc/procesar_login.php" method="post">
        <div class="box">
            <div class="container-login">
                <div class="top-header">
                    <img class="img-login" src="../img/logo1.jpeg" alt="logo">
                    <header class="header-login">Iniciar Sesión</header>
                </div>
                <div class="input-field">
                    <input class="input" type="text" id="username" name="username" placeholder="Usuario" required>
                </div>
                <div class="input-field">
                    <input class="input" type="password" id="password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="input-field">
                    <button class="submit" type="submit">Iniciar Sesión</button>
                </div>
            </div> 
        </div>  
    </form>
    
    
    <?php
    if(isset($_GET['error']) && $_GET['error'] == 1 ){
        echo "<p>Error: El usuario o la contraseña es incorrecta</p>";
    }
    ?>


    
</body>
</html>
