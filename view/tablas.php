<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once '../conexion/conexion.php';

// Obtener filtro seleccionado
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

// Preparamos SQL según el filtro seleccionado
switch ($filtro) {
    case 'nombre':
        $sql = "SELECT * FROM tbl_alumno ORDER BY nom_alu";
        break;
    case 'apellido1_alu':
        $sql = "SELECT * FROM tbl_alumno ORDER BY apellido1_alu";
        break;
    case 'apellido2_alu':
        $sql = "SELECT * FROM tbl_alumno ORDER BY apellido2_alu";
        break;
    case 'dni_alum':
        $sql = "SELECT * FROM tbl_alumno ORDER BY dni_alum";
        break;
    case 'email_alum':
        $sql = "SELECT * FROM tbl_alumno ORDER BY email_alum";
        break;
    case 'telf_alum':
        $sql = "SELECT * FROM tbl_alumno ORDER BY telf_alum";
        break;
    case 'codi_clase':
        $sql = "SELECT * FROM tbl_alumno inner join tbl_clase ORDER BY codi_clase";
        break;
    default:
        $sql = 'SELECT id_alumno,nom_alu,apellido1_alu,apellido2_alu,dni_alum,email_alum,telf_alum,codi_clase from tbl_alumno inner join tbl_clase on tbl_alumno.id_clase = tbl_clase.id_clase order by id_alumno asc';
}

// Verificar si se ha enviado una consulta de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM tbl_alumno  inner join tbl_clase WHERE nom_alu LIKE '%$search%' OR apellido1_alu LIKE '%$search%' OR apellido2_alu LIKE '%$search%' OR dni_alum LIKE '%$search%' OR email_alum LIKE '%$search%' OR telf_alum LIKE '%$search%' OR codi_clase LIKE '%$search%'";
}

// Ejecutamos la consulta
$consulta = $pdo->query($sql);
$resultados = $consulta->fetchAll();
?>


<div class="container mt-5">
    <!-- Barra de búsqueda -->
    <div class="row mb-3">
        <div class="col">
            <form action="#" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Menú de filtrado -->
    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="filtro">Filtrar por</label>
                </div>
                <select class="custom-select" id="filtro" onchange="location = this.value;">
                    <option value="?filtro=" <?php if ($filtro == '') echo 'selected'; ?>>Seleccionar...</option>
                    <option value="?filtro=nom_alu" <?php if ($filtro == 'nombre') echo 'selected'; ?>>Nombre</option>
                    <option value="?filtro=apellido1_alu" <?php if ($filtro == '1r_apellido') echo 'selected'; ?>>1er Apellido</option>
                    <option value="?filtro=apellido2_alu" <?php if ($filtro == '2do_apellido') echo 'selected'; ?>>2do Apellido</option>
                    <option value="?filtro=dni_alum" <?php if ($filtro == 'dni') echo 'selected'; ?>>DNI</option>
                    <option value="?filtro=email_alum" <?php if ($filtro == 'mail') echo 'selected'; ?>>Correo Electrónico</option>
                    <option value="?filtro=telf_alum" <?php if ($filtro == 'telf') echo 'selected'; ?>>Teléfono</option>
                    <option value="?filtro=codi_clase" <?php if ($filtro == 'clase') echo 'selected'; ?>>Clase</option>
                </select>
            </div>
        </div>
    </div>
    <!-- Botón de agregar nuevo -->
    <div class="row">
        <div class="col text-right">
            <a href='../acciones/crear.php' class='btn btn-success'>Añadir Nuevo</a>
        </div>
    </div>
    <!-- Tabla principal -->
    <div class="row mt-3">
        <div class="col">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">1r Apellido</th>
                        <th scope="col">2do Apellido</th>
                        <th scope="col">DNI</th>
                        <th scope="col">MAIL</th>
                        <th scope="col">Telf</th>
                        <th scope="col">Clase</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $columna) : ?>
                        <tr>
                            <td><?php echo $columna['id_alumno']; ?></td>
                            <td><?php echo $columna['nom_alu']; ?></td>
                            <td><?php echo $columna['apellido1_alu']; ?></td>
                            <td><?php echo $columna['apellido2_alu']; ?></td>
                            <td><?php echo $columna['dni_alum']; ?></td>
                            <td><?php echo $columna['email_alum']; ?></td>
                            <td><?php echo $columna['telf_alum']; ?></td>
                            <td><?php echo $columna['codi_clase']; ?></td>
                            <td>
                                <a href="../acciones/modificar.php?id_alumno=<?php echo $columna['id_alumno']; ?>" class="btn btn-info btn-sm">Modificar</a>
                                <a href="../acciones/borrar.php?id_alumno=<?php echo $columna['id_alumno']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
