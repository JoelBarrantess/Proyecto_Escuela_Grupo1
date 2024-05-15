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
    <title>Editar <?php echo $tabla == 'alumnos' ? 'Alumno' : 'Profesor'; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Editar <?php echo $tabla == 'alumnos' ? 'Alumno' : 'Profesor'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="../acciones/editar.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $datos['id_' . ($tabla == 'profesores' ? 'profesor' : 'alumno')]; ?>">
                            <input type="hidden" name="tabla" value="<?php echo $tabla; ?>">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $datos['nom_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido1">Primer Apellido:</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo $datos['apellido1_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido2">Segundo Apellido:</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo $datos['apellido2_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $datos['dni_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $datos['email_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $datos['telf_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?>">
                            </div>
                            <?php if ($tabla == 'alumnos'): ?>
                            <div class="form-group">
                                <label for="clase">Clase:</label>
                                <select class="form-control" id="clase" name="clase" required>
                                    <option value="1" <?php if ($datos['id_clase'] == 1) echo 'selected'; ?>>Sistemas Microinformatics i Xarxes</option>
                                    <option value="2" <?php if ($datos['id_clase'] == 2) echo 'selected'; ?>>Desenvolupament de Aplicacions en Entorns Web</option>
                                    <option value="3" <?php if ($datos['id_clase'] == 3) echo 'selected'; ?>>Administració de Sistemes Informatics i Xarxes</option>
                                    <option value="4" <?php if ($datos['id_clase'] == 4) echo 'selected'; ?>>Gestión de Proyectos Informáticos</option>
                                </select>
                            </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

