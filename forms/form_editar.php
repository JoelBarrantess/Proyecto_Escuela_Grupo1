<?php
require_once '../conexion/conexion.php';

if ((isset($_GET['id_alumno']) || isset($_GET['id_profesor'])) && isset($_GET['tabla'])) {
    $id = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : $_GET['id_profesor'];
    $tabla = $_GET['tabla'];

    if ($tabla == 'alumnos' && isset($_GET['id_alumno'])) {
        $consulta = $pdo->prepare('SELECT * FROM tbl_alumno WHERE id_alumno = :id');
    } elseif ($tabla == 'profesores' && isset($_GET['id_profesor'])) {
        $consulta = $pdo->prepare('SELECT * FROM tbl_profesor WHERE id_profesor = :id');
    } else {
        header('Location: ../view/tablas.php?tabla=alumnos');
        exit();
    }

    $consulta->execute(['id' => $id]);
    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
    } else {
        echo "No se encontraron datos.";
    }
} else {
    header('Location: ../view/tablas.php?tabla=alumnos');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Muestra el titulo, si la tabla es "alumnos" mostrara "Alumno", si no "Profesor" -->
    <title>Editar <?php echo $tabla == 'alumnos' ? 'Alumno' : 'Profesor'; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-body">
                        <form action="../acciones/editar.php" method="POST">
                            <div class="box">
                                <div class="container-login">
                                    <div class="top-header">
                                        <header class="header-login btn-login">Editar</header>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $datos['id_' . ($tabla == 'profesores' ? 'profesor' : 'alumno')]; ?>">
                                    <input type="hidden" name="tabla" value="<?php echo $tabla; ?>">
                                    <div class="input-field">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="input" id="nombre" name="nombre" value="<?php echo $datos['nom_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" oninput="validarNombre()" required>
                                        <p id='error_nombre' class="error-validacion"></p>
                                    </div>
                                    <div class="input-field">
                                        <label for="apellido1">Primer Apellido:</label>
                                        <input type="text" class="input" id="apellido1" name="apellido1" value="<?php echo $datos['apellido1_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" oninput="validarApellido1()" required>
                                        <p id='error_apellido1' class="error-validacion"></p>
                                    </div>
                                    <div class="input-field">
                                        <label for="apellido2">Segundo Apellido:</label>
                                        <input type="text" class="input" id="apellido2" name="apellido2" value="<?php echo $datos['apellido2_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" oninput="validarApellido2()" required>
                                        <p id='error_apellido2' class="error-validacion"></p>
                                    </div>
                                    <div class="input-field">
                                        <label for="dni">DNI:</label>
                                        <input type="text" class="input" id="dni" name="dni" value="<?php echo $datos['dni_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>" oninput="validarDNI()" required>
                                        <p id="error_dni" class="error-validacion"></p>
                                    </div>
                                    <div class="input-field">
                                        <label for="email">Correo Electrónico:</label>
                                        <input type="email" class="input" id="email" name="email" value="<?php echo $datos['email_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>" oninput="validarEmail()">
                                        <p id="error_email" class="error-validacion"></p>
                                    </div>
                                    <div class="input-field">
                                        <label for="telefono">Teléfono:</label>
                                        <input type="tel" class="input" id="telefono" name="telefono" value="<?php echo $datos['telf_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>" oninput="validarNumero()">
                                        <p id="error_telefono" class="error-validacion"></p>
                                    </div>
                                    <?php if ($tabla == 'alumnos'): ?>
                                    <div class="input-field">
                                        <label for="clase">Clase:</label>
                                        <select class="input" id="clase" name="clase" required>
                                            <option value="1" <?php if ($datos['id_clase'] == 1) echo 'selected'; ?>>Sistemas Microinformatics i Xarxes</option>
                                            <option value="2" <?php if ($datos['id_clase'] == 2) echo 'selected'; ?>>Desenvolupament de Aplicacions en Entorns Web</option>
                                            <option value="3" <?php if ($datos['id_clase'] == 3) echo 'selected'; ?>>Administració de Sistemes Informatics i Xarxes</option>
                                            <option value="4" <?php if ($datos['id_clase'] == 4) echo 'selected'; ?>>Gestión de Proyectos Informáticos</option>
                                        </select>
                                    </div>
                                    <?php endif; ?>
                                    <button type="submit" class="submit">Guardar Cambios</button>
                                    <form action="../view/tablas.php">
                                        <button type="submit" class="submit" >Cancelar</button>
                                    </form>
                                </div> 
                            </div>          
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/scripts.js" defer></script>
</body>
</html>

