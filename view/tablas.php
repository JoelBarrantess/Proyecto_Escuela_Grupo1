<?php
   session_start(); 
    if(!isset($_SESSION['loginok'])){
    header("location: ./login.php?error=2"); 
}
?>
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
    require_once '../conexion/conexion.php';

    // Preparamos SQL
    $consulta = $pdo->query('select id_alumno,nom_alu,apellido1_alu,apellido2_alu,dni_alum,email_alum,telf_alum,codi_clase from tbl_alumno inner join tbl_clase on tbl_alumno.id_clase = tbl_clase.id_clase order by id_alumno asc;');

    // Ejecutamos la consulta
    $consulta->execute();

    $resultados = $consulta->fetchAll();
    ?>

    <div class="container mt-5">
        <div class="row">
            <!-- Tabla principal -->
            <div class="col">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Primer Apellido</th>
                            <th scope="col">Segundo Apellido</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Clase</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Imprimir datos de tabla principal
                        foreach ($resultados as $posicion => $columna) {
                            echo "<tr>";
                            for ($i = 0; $i < $consulta->columnCount(); $i++) {
                                echo "<td>" . $columna[$i] . "</td>";
                            }
                            echo "<td class='text-center'><a href='editar.php?id_alumno=" . $columna['id_alumno'] . "' class='btn btn-primary btn-sm mr-1'>Editar</a><a href='borrar.php?id_alumno=" . $columna['id_alumno'] . "' class='btn btn-danger btn-sm'>Borrar</a></td>";
                                                        
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabla de añadir -->
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Añadir Nuevo</h5>
                        <a href='../forms/form_crear.php' class='btn btn-success btn-block'>Añadir Nuevo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>