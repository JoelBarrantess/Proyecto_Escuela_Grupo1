<?php
    session_start();
    if(!isset($_SESSION['loginok'])){
    header("location: ./login.php?error=2"); 
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   
</head>
<body>
<?php
require_once '../conexion/conexion.php';

// Obtener filtro seleccionado
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';
// Obtener tabla seleccionada
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : 'alumnos';

// Preparamos SQL según el filtro seleccionado y la tabla
switch ($filtro) {
    case 'nombre':
        $order_by = ($tabla == 'alumnos') ? 'a.nom_alu' : 'p.nom_prof';
        break;
    case 'apellido1':
        $order_by = ($tabla == 'alumnos') ? 'a.apellido1_alu' : 'p.apellido1_prof';
        break;
    case 'apellido2':
        $order_by = ($tabla == 'alumnos') ? 'a.apellido2_alu' : 'p.apellido2_prof';
        break;
    case 'dni':
        $order_by = ($tabla == 'alumnos') ? 'a.dni_alum' : 'p.dni_prof';
        break;
    case 'email':
        $order_by = ($tabla == 'alumnos') ? 'a.email_alum' : 'p.email_prof';
        break;
    case 'telefono':
        $order_by = ($tabla == 'alumnos') ? 'a.telf_alum' : 'p.telf_prof';
        break;
    case 'clase':
        $order_by = ($tabla == 'alumnos') ? 'c.codi_clase' : 'c.nombre_clase';
        break;
    default:
        $order_by = ($tabla == 'alumnos') ? 'a.id_alumno' : 'p.id_profesor';
}

// Construimos la consulta dependiendo de la tabla seleccionada
if ($tabla == 'alumnos') {
    $sql = "SELECT DISTINCT a.*, c.codi_clase 
            FROM tbl_alumno a 
            LEFT JOIN tbl_clase c ON a.id_clase = c.id_clase 
            GROUP BY a.id_alumno 
            ORDER BY $order_by ASC";
} elseif ($tabla == 'profesores') {
    $sql = "SELECT DISTINCT p.*, c.nombre_clase 
            FROM tbl_profesor p 
            LEFT JOIN tbl_clase c ON p.id_profesor = c.id_profesor 
            ORDER BY $order_by ASC";
}

// Verificar si se ha enviado una consulta de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    if ($tabla == 'alumnos') {
        $sql = "SELECT DISTINCT a.*, c.codi_clase 
                FROM tbl_alumno a 
                LEFT JOIN tbl_clase c ON a.id_clase = c.id_clase 
                WHERE a.nom_alu LIKE '%$search%' 
                    OR a.apellido1_alu LIKE '%$search%' 
                    OR a.apellido2_alu LIKE '%$search%' 
                    OR a.dni_alum LIKE '%$search%' 
                    OR a.email_alum LIKE '%$search%' 
                    OR a.telf_alum LIKE '%$search%' 
                    OR c.codi_clase LIKE '%$search%' 
                GROUP BY a.id_alumno 
                ORDER BY $order_by ASC";
    } elseif ($tabla == 'profesores') {
        $sql = "SELECT DISTINCT p.*, c.nombre_clase 
                FROM tbl_profesor p 
                LEFT JOIN tbl_clase c ON p.id_profesor = c.id_profesor 
                WHERE p.nom_prof LIKE '%$search%' 
                    OR p.apellido1_prof LIKE '%$search%' 
                    OR p.apellido2_prof LIKE '%$search%' 
                    OR p.dni_prof LIKE '%$search%' 
                    OR p.email_prof LIKE '%$search%' 
                    OR p.telf_prof LIKE '%$search%' 
                    OR c.nombre_clase LIKE '%$search%' 
                ORDER BY $order_by ASC";
    }
}
// Ejecutamos la consulta
$consulta = $pdo->query($sql);
$resultados = $consulta->fetchAll();
// Construir la consulta para obtener el total de registros
$sql_count = "SELECT COUNT(*) AS total_registros FROM ($sql) AS count_table";
$consulta_count = $pdo->query($sql_count);
$total_registros = $consulta_count->fetchColumn();
?>


<div class="container mt-5">
<!-- Barra de búsqueda -->
<div class="row mb-3">
    <div class="col">
        <form action="#" method="GET">
            <!-- Campo oculto para mantener el tipo de tabla seleccionado -->
            <input type="hidden" name="tabla" value="<?php echo isset($_GET['tabla']) ? $_GET['tabla'] : 'alumnos'; ?>">
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
                <?php if (isset($_GET['tabla']) && $_GET['tabla'] == 'profesores'): ?>
                    <option value="?tabla=profesores&filtro=" <?php if ($filtro == '') echo 'selected'; ?>>Seleccionar...</option>
                    <option value="?tabla=profesores&filtro=nombre" <?php if ($filtro == 'nombre') echo 'selected'; ?>>Nombre</option>
                    <option value="?tabla=profesores&filtro=apellido1" <?php if ($filtro == 'apellido1') echo 'selected'; ?>>1er Apellido</option>
                    <option value="?tabla=profesores&filtro=apellido2" <?php if ($filtro == 'apellido2') echo 'selected'; ?>>2do Apellido</option>
                    <option value="?tabla=profesores&filtro=dni" <?php if ($filtro == 'dni') echo 'selected'; ?>>DNI</option>
                    <option value="?tabla=profesores&filtro=email" <?php if ($filtro == 'email') echo 'selected'; ?>>Correo Electrónico</option>
                    <option value="?tabla=profesores&filtro=telefono" <?php if ($filtro == 'telefono') echo 'selected'; ?>>Teléfono</option>
                <?php else: ?>
                    <option value="?tabla=alumnos&filtro=" <?php if ($filtro == '') echo 'selected'; ?>>Seleccionar...</option>
                    <option value="?tabla=alumnos&filtro=nombre" <?php if ($filtro == 'nombre') echo 'selected'; ?>>Nombre</option>
                    <option value="?tabla=alumnos&filtro=apellido1" <?php if ($filtro == 'apellido1') echo 'selected'; ?>>1er Apellido</option>
                    <option value="?tabla=alumnos&filtro=apellido2" <?php if ($filtro == 'apellido2') echo 'selected'; ?>>2do Apellido</option>
                    <option value="?tabla=alumnos&filtro=dni" <?php if ($filtro == 'dni') echo 'selected'; ?>>DNI</option>
                    <option value="?tabla=alumnos&filtro=email" <?php if ($filtro == 'email') echo 'selected'; ?>>Correo Electrónico</option>
                    <option value="?tabla=alumnos&filtro=telefono" <?php if ($filtro == 'telefono') echo 'selected'; ?>>Teléfono</option>
                    <option value="?tabla=alumnos&filtro=clase" <?php if ($filtro == 'clase') echo 'selected'; ?>>Clase</option>
                <?php endif; ?>
            </select>
        </div>
    </div>
</div>
    <div class="row mb-3">
    <div class="col">
        <div class="input-group">
        <?php if(isset($_SESSION['loginadmin'])): ?>
            <div class="input-group-prepend">
                <label class="input-group-text" for="tabla">Seleccionar tabla</label>
            </div>
            <select class="custom-select" id="tabla" onchange="location = this.value;">
                <option value="?tabla=alumnos" <?php if (!isset($_GET['tabla']) || $_GET['tabla'] == 'alumnos') echo 'selected'; ?>>Alumnos</option>
                <option value="?tabla=profesores" <?php if (isset($_GET['tabla']) && $_GET['tabla'] == 'profesores') echo 'selected'; ?>>Profesores</option>
            </select>
        <?php endif;?>
        </div>
    </div>
</div>

    <!-- Botón de agregar nuevo
    <?php if(isset($_SESSION['loginadmin'])): ?>
    <div class="row">
        <div class="col text-right">
            <a href='../forms/form_crear.php' class='btn btn-success'>Añadir Nuevo</a>
        </div>
    </div> -->
    <form>
  <div id="opciones" class="opciones">
    <label for="añadir">AÑADIR NUEVO</label>
    <select id="añadir">
      <option value="profesor_alumno">AÑADIR PROFESOR/ALUMNO</option>
      <option value="login">AÑADIR LOGIN</option>
    </select>
  </div>
</form>
    <?php endif;?>
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
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Teléfono</th>
                    <?php if (isset($_GET['tabla']) && $_GET['tabla'] == 'alumnos'): ?>
                        <th scope="col">Clase</th>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['loginadmin'])): ?>
                    <th scope="col">Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $columna) : ?>
                    <tr>
                        <td><?php echo $columna['id_' . ($_GET['tabla'] == 'profesores' ? 'profesor' : 'alumno')]; ?></td>
                        <td><?php echo $columna['nom_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alu')]; ?></td>
                        <td><?php echo $columna['apellido1_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alu')]; ?></td>
                        <td><?php echo $columna['apellido2_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alu')]; ?></td>
                        <td><?php echo $columna['dni_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alum')]; ?></td>
                        <td><?php echo $columna['email_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alum')]; ?></td>
                        <td><?php echo $columna['telf_' . ($_GET['tabla'] == 'profesores' ? 'prof' : 'alum')]; ?></td>
                        <?php if (isset($_GET['tabla']) && $_GET['tabla'] == 'alumnos'): ?>
                            <td><?php echo $columna['codi_clase']; ?></td>
                        <?php endif;?>
                        <?php if(isset($_SESSION['loginadmin'])): ?>
                        <td>
                            
                        <a href="../forms/form_editar.php?id_<?php echo ($_GET['tabla'] == 'profesores' ? 'profesor' : 'alumno')."=". $columna['id_'.($_GET['tabla'] == 'profesores' ? 'profesor' : 'alumno')]; echo "&tabla=".$tabla; ?>" class="btn btn-info btn-sm">Modificar</a>
                        <!-- Boton de eliminar -->
                        <a href="#" onclick="confirmarEliminar('<?php echo $columna['id_' . ($_GET['tabla'] == 'profesores' ? 'profesor' : 'alumno')]; ?>')" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                        <?php endif;?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
                    <!-- Mostrar el total de registros -->
        <div class="row mt-3">
            <div class="col">
                <p>Mostrando un total de <?php echo $total_registros; ?> registros</p>
            </div>
        </div>
        </table>
        <a href="../proc/cerrar-sesion.php" class="btn btn-info btn-sm">Cerrar sesión</a>
        <br><br>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
