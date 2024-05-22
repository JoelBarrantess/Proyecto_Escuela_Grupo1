<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/scripts.js"></script>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['loginok'])) {
    header("location: ./login.php?error=2");
    exit;
}

require_once '../conexion/conexion.php';

$id_profesor = null;
if (isset($_SESSION['loginprofe'])) {
    $id_profesor = $_SESSION['id_profesor'];
}

// Parámetros de paginación
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener filtro seleccionado
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

// Obtener orden seleccionado
$orden = isset($_GET['orden']) ? strtoupper($_GET['orden']) : 'ASC';
$orden = ($orden === 'DESC') ? 'DESC' : 'ASC';

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
    $sql_base = "SELECT DISTINCT a.*, c.codi_clase 
            FROM tbl_alumno a 
            LEFT JOIN tbl_clase c ON a.id_clase = c.id_clase ";
    if ($id_profesor) {
        $sql_base .= "INNER JOIN tbl_profesor p ON c.id_profesor = p.id_profesor WHERE p.id_profesor = :id_profesor ";
    }
    $sql_base .= "GROUP BY a.id_alumno 
             ORDER BY $order_by $orden";
} elseif ($tabla == 'profesores') {
    $sql_base = "SELECT DISTINCT p.*, c.nombre_clase 
            FROM tbl_profesor p 
            LEFT JOIN tbl_clase c ON p.id_profesor = c.id_profesor 
            ORDER BY $order_by $orden";
}

// Verificar si se ha enviado una consulta de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    if ($tabla == 'alumnos') {
        $sql_base = "SELECT DISTINCT a.*, c.codi_clase 
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
                ORDER BY $order_by $orden";
        if ($id_profesor) {
            $sql_base .= " AND p.id_profesor = :id_profesor";
        }
    } elseif ($tabla == 'profesores') {
        $sql_base = "SELECT DISTINCT p.*, c.nombre_clase 
                FROM tbl_profesor p 
                LEFT JOIN tbl_clase c ON p.id_profesor = c.id_profesor 
                WHERE p.nom_prof LIKE '%$search%' 
                    OR p.apellido1_prof LIKE '%$search%' 
                    OR p.apellido2_prof LIKE '%$search%' 
                    OR p.dni_prof LIKE '%$search%' 
                    OR p.email_prof LIKE '%$search%' 
                    OR p.telf_prof LIKE '%$search%' 
                    OR c.nombre_clase LIKE '%$search%' 
                ORDER BY $order_by $orden";
    }
}

// Construir la consulta para obtener el total de registros
$sql_count = "SELECT COUNT(*) AS total_registros FROM ($sql_base) AS count_table";
$consulta_count = $pdo->prepare($sql_count);
if ($id_profesor) {
    $consulta_count->bindParam(':id_profesor', $id_profesor);
}
$consulta_count->execute();
$total_registros = $consulta_count->fetchColumn();

// Agregar LIMIT y OFFSET a la consulta principal
$sql = $sql_base . " LIMIT $registros_por_pagina OFFSET $offset";

// Ejecutamos la consulta
$consulta = $pdo->prepare($sql);
if ($id_profesor) {
    $consulta->bindParam(':id_profesor', $id_profesor);
}
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Calcular el total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>

<!-- Navbar -->
<nav class="header">
    <img src="../img/logo2.png" alt="Logo" class="logo">
    <a href="../proc/cerrar-sesion.php" class="btn btn-info btn-sm">Cerrar sesión</a>
</nav>

<div class="container mt-5">
    <!-- Barra de búsqueda -->
    <div class="row mb-3">
        <div class="col">
            <form action="#" method="GET">
                <input type="hidden" name="tabla" value="<?php echo $tabla; ?>">
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
                    <label class="input-group-text" for="filtro">Ordenar por</label>
                </div>
                <select class="custom-select" id="filtro" onchange="location = this.value;">
                    <?php if ($tabla == 'profesores'): ?>
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
                <select class="custom-select" id="orden" onchange="location = this.value;">
                    <option value="?tabla=<?php echo $tabla; ?>&filtro=<?php echo $filtro; ?>&orden=ASC" <?php if ($orden == 'ASC') echo 'selected'; ?>>Ascendente</option>
                    <option value="?tabla=<?php echo $tabla; ?>&filtro=<?php echo $filtro; ?>&orden=DESC" <?php if ($orden == 'DESC') echo 'selected'; ?>>Descendente</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Selección de tabla -->
    <div class="row mb-3">
        <div class="col">
            <div class="input-group">
                <?php if(isset($_SESSION['loginadmin'])): ?>
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="tabla">Seleccionar tabla</label>
                    </div>
                    <select class="custom-select" id="tabla" onchange="location = this.value;">
                        <option value="?tabla=alumnos" <?php if ($tabla == 'alumnos') echo 'selected'; ?>>Alumnos</option>
                        <option value="?tabla=profesores" <?php if ($tabla == 'profesores') echo 'selected'; ?>>Profesores</option>
                    </select>
                <?php endif;?>
            </div>
        </div>
    </div>

    <!-- Botón de agregar nuevo -->
    <?php if(isset($_SESSION['loginadmin'])): ?>
    <div class="row">
        <div class="col text-right">
            <a href='../forms/form_crear.php' class='btn btn-success btn-tabla1'>Añadir Nuevo</a>
        </div>
    </div>

    <!-- Botón exportar a csv -->
    <div class="row margin">
        <div class="col text-right">
            <a href='../acciones/exportar_csv.php?tabla=<?php echo $tabla; ?>' class='btn btn-success btn-tabla1'>Exportar</a>
        </div>
    </div>
    <?php endif;?>


    <!-- Tabla principal -->
    <div class="row mt-3">
        <div class="col">
            <div class="table-responsive"> <!-- Added table-responsive class -->
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <?php if(isset($_SESSION['loginadmin'])): ?>
                            <th scope="col">Nº</th>
                            <?php endif;?>
                            <th scope="col">Nombre</th>
                            <th scope="col">1r Apellido</th>
                            <th scope="col">2do Apellido</th>
                            <th scope="col">DNI</th>
                            <th class="ocultar" scope="col">Correo Electrónico</th>
                            <th class="ocultar" scope="col">Teléfono</th>
                            <?php if ($tabla == 'alumnos'): ?>
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
                                <?php if(isset($_SESSION['loginadmin'])): ?>
                                <td data-label="Nº"><?php echo $columna['id_' . ($tabla == 'profesores' ? 'profesor' : 'alumno')]; ?></td>
                                <?php endif;?>
                                <td data-label="Nombre"><?php echo $columna['nom_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?></td>
                                <td data-label="1r Apellido"><?php echo $columna['apellido1_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?></td>
                                <td data-label="2do Apellido"><?php echo $columna['apellido2_' . ($tabla == 'profesores' ? 'prof' : 'alu')]; ?></td>
                                <td data-label="DNI"><?php echo $columna['dni_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?></td>
                                <td class="ocultar" data-label="Correo Electrónico"><?php echo $columna['email_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?></td>
                                <td class="ocultar" data-label="Teléfono"><?php echo $columna['telf_' . ($tabla == 'profesores' ? 'prof' : 'alum')]; ?></td>
                                <?php if ($tabla == 'alumnos'): ?>
                                    <td data-label="Clase"><?php echo $columna['codi_clase']; ?></td>
                                <?php endif;?>
                                <?php if(isset($_SESSION['loginadmin'])): ?>
                                <td data-label="Acciones">
                                    <a href="../forms/form_editar.php?id_<?php echo ($tabla == 'profesores' ? 'profesor' : 'alumno')."=". $columna['id_'.($tabla == 'profesores' ? 'profesor' : 'alumno')]; echo "&tabla=".$tabla; ?>" class="btn btn-info btn-sm btn-tabla">Modificar</a>
                                    <a href="javascript:void(0);" onclick="confirmarEliminar(<?php echo $columna['id_'.($tabla == 'profesores' ? 'profesor' : 'alumno')]; ?>, '<?php echo ($tabla == 'profesores' ? 'id_profesor' : 'id_alumno'); ?>')" class="btn btn-danger btn-sm btn-tabla">Eliminar</a>
                                </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> 
            
            <!-- Mostrar el total de registros -->
            <div class="row mt-3">
                <div class="col">
                    <p>Total de registros: <?php echo $total_registros; ?></p>
                </div>
            </div>

            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($pagina_actual <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="?tabla=<?php echo $tabla; ?>&filtro=<?php echo $filtro; ?>&pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Anterior</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?php if($pagina_actual == $i){ echo 'active'; } ?>">
                            <a class="page-link" href="?tabla=<?php echo $tabla; ?>&filtro=<?php echo $filtro; ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($pagina_actual >= $total_paginas){ echo 'disabled'; } ?>">
                        <a class="page-link" href="?tabla=<?php echo $tabla; ?>&filtro=<?php echo $filtro; ?>&pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
        <br><br>
    </div>
        
    </div>
</div>
<!-- Por si te has colado -->
<?php
if(isset($_GET['desconexion']) && $_GET['desconexion'] == 1 ){
    echo "<p class='error-login'>Te has desconectado.</p>";
    }
?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

