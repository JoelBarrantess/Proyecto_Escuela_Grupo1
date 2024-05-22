<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-body">
    <div class="box">
        <div class="container-login">
            <div class="top-header">
                <header class="header-login btn-login">Crear Usuario</header>
            </div>
            <form action="../acciones/crear.php" method="POST" id="formulario_crear">
                <div class="input-field">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <select class="input" id="tipo_usuario" name="tipo_usuario" onchange="campoClase()" onblur="validarSeleccion()" required>
                        <option value="">Seleccione...</option>
                        <option value="alumno">Alumno</option>
                        <option value="profesor">Profesor</option>
                    </select>
                    <p id='error_usuario' class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="nombre">Nombre:</label>
                    <input class="input" type="text" id="nombre" name="nombre" oninput="validarNombre()" required>
                    <p id='error_nombre' class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="apellido1">Primer Apellido:</label>
                    <input class="input" type="text" id="apellido1" name="apellido1" oninput="validarApellido1()" required>
                    <p id='error_apellido1' class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="apellido2">Segundo Apellido:</label>
                    <input class="input" type="text" id="apellido2" name="apellido2" oninput="validarApellido2()" required>
                    <p id='error_apellido2' class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="dni">DNI:</label>
                    <input class="input" type="text" id="dni" name="dni" oninput="validarDNI()" required>
                    <p id="error_dni" class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="email">Correo Electrónico:</label>
                    <input class="input" type="email" id="email" name="email" oninput="validarEmail()" required>
                    <p id="error_email" class="error-validacion"></p>
                </div>
                <div class="input-field">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" class="input" id="telefono" name="telefono" oninput="validarNumero()" required>
                    <p id="error_telefono" class="error-validacion"></p>
                </div>
                <div class="input-field" id="clase_field" style="display: none;">
                    <label for="clase">Clase:</label>
                    <select class="input" id="clase" name="clase">
                        <option value="1">Sistemas Microinformatics i Xarxes</option>
                        <option value="2">Desenvolupament de Aplicacions en Entorns Web</option>
                        <option value="3">Administració de Sistemes Informatics i Xarxes</option>
                        <option value="4">Gestión de Proyectos Informáticos</option>
                    </select>
                </div>
                <button type="submit" class="submit">Enviar</button>
            </form>
            <form action="../view/tablas.php">
                    <button type="submit" class="submit">Cancelar</button>
            </form>     
        </div> 
    </div>

    <!-- Script javascript -->
    <script src="../js/scripts.js"></script>
</body>
</html>
