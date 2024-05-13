<?php
require_once '../conexion/conexion.php';
?>
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">NUEVO ALUMNO</h5>
                    </div>
                    <div class="card-body">
                        <form action="procesar_crear.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido1">Primer Apellido:</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido2">Segundo Apellido:</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="clase">Clase:</label>
                                <select class="form-control" id="clase" name="clase" required>
                                    <!-- Aquí se puede obtener la lista de clases desde la base de datos -->
                                    <!-- O se puede proporcionar manualmente -->
                                    <option value="1">Sistemas Microinformatics i Xarxes</option>
                                    <option value="2">Desenvolupament de Aplicacions en Entorns Web</option>
                                    <option value="3">Administració de Sistemes Informatics i Xarxes</option>
                                    <option value="4">Gestión de Proyectos Informáticos</option>
                                </select>
                            </div><br>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>