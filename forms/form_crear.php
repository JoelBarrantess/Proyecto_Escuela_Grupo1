<?php session_start();?>
<?php if(isset($_SESSION['loginadmin'])): ?>
<?php require_once '../conexion/conexion.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="form_crear">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">CREAR USUARIO</h5>
                    </div>
                    <div class="card-body">
                        <form action="../acciones/crear.php" method="POST" id="formulario_crear">
                            <div class="form-group">
                                <label for="tipo_usuario">Tipo de Usuario:</label>
                                <select class="form-control" id="tipo_usuario" name="tipo_usuario" onchange="campoClase()" onblur="validarSeleccion()" required>
                                    <option value="">Seleccione...</option>
                                    <option value="alumno">Alumno</option>
                                    <option value="profesor">Profesor</option>
                                </select>
                                <p id='error_usuario' class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" oninput="validarNombre()" required>
                                <p id='error_nombre' class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="apellido1">Primer Apellido:</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" oninput="validarApellido1()" required>
                                <p id='error_apellido1' class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="apellido2">Segundo Apellido:</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" oninput="validarApellido2()" required>
                                <p id='error_apellido2' class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" oninput="validarDNI()" required>
                                <p id="error_dni" class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" oninput="validarEmail()" required>
                                <p id="error_email" class="error-validacion"></p>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" oninput="validarNumero()" required>
                                <p id="error_telefono" class="error-validacion"></p>
                            </div>
                            <div class="form-group" id="clase_field" style="display: none;">
                                <label for="clase">Clase:</label>
                                <select class="form-control" id="clase" name="clase">
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
    <!-- Script javascript -->
    <script src="../js/scripts.js" defer></script>
</body>
</html>


<?php 
elseif (!$_SESSION['loginadmin']): 
     header('Location: ../view/tablas.php?tabla=alumnos?colarse=1');
endif; 
?>