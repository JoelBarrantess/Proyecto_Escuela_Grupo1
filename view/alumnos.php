<?php
require_once '../conexion/conexion.php';
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Bienvenida</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link css -->
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/scripts.js"></script>
</head>
<body class="alumno-body">
<?php
session_start();
if (!isset($_SESSION['loginok'])) {
    header("location: ./login.php?error=2");
    exit;
}
$id_alumno = null;
if (isset($_SESSION['loginalum'])) {
    $id_alumno = $_SESSION['id_alumno'];
}

//Consulta SQL
$consulta_alum = "SELECT CONCAT(nom_alu, ' ', apellido1_alu, ' ', apellido2_alu) AS nombre_completo 
            FROM tbl_alumno 
            WHERE id_alumno = :id_alumno;";
// Preparar y ejecutar la consulta
$consulta = $pdo->prepare($consulta_alum);
$consulta->bindParam(':id_alumno', $id_alumno);
$consulta->execute();
// Obtener el resultado
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

// Almacenar el nombre completo en una variable
$nombre_completo = $resultado['nombre_completo'];

?>

<nav class="header">
    <img src="../img/logo2.png" alt="Logo" class="logo">
    <a class="links ocultar" href="#">Inicio</a>
    <a class="links ocultar" href="#">Cursos</a>
    <a class="links ocultar" href="#">Evaluaciones</a>
    <a class="links ocultar" href="#">Notas</a>
    <a class="links ocultar" href="#">Mensajes</a>
    <a class="links ocultar" href="#">Biblioteca</a>
    <a class="links ocultar" href="#">Configuración</a>
    <a href="../proc/cerrar-sesion.php" class="btn btn-info btn-sm links">Cerrar sesión</a>
</nav>
    
    <div class="contenedor">
        <div class="bienvenida">
            <h1>Bienvenido, <?php echo $nombre_completo; ?></h1>
        </div>
        <section class="seccion">
            <h2>Próximas Actividades</h2>
            <div class="notification">
                <p>Trabajo de Matemáticas: Entrega el 25 de mayo</p>
                <p>Examen de Historia: 30 de mayo</p>
                <p>Presentación de Proyecto de Ciencias: 10 de junio</p>
            </div>
        </section>
        <section class="seccion">
            <h2>Notificaciones</h2>
            <div class="notification">
                <p>Nuevo mensaje de tu profesor de Literatura sobre la próxima lectura obligatoria.</p>
            </div>
        </section>
        <section class="seccion">
            <h2>Calificaciones y Progreso</h2>
            <div class="notificacion">
                <ul>
                    <li>Matemáticas: 95%</li>
                    <li>Historia: 87%</li>
                    <li>Ciencias: 91%</li>
                    <li>Inglés: 83%</li>
                </ul>
            </div>
        </section>
        <section class="seccion">
            <h2>Enlaces Rápidos</h2>
            <ul>
                <li><a href="#">Biblioteca Digital</a></li>
                <li><a href="#">Foro de Discusión</a></li>
                <li><a href="#">Herramientas de Estudio</a></li>
            </ul>
        </section>
        <section class="seccion">
            <h2>Mensajes</h2>
            <div class="notification">
                <p>Mensaje de tu compañero de clase sobre el proyecto de grupo en Biología.</p>
            </div>
        </section>
        <section class="seccion ultima">
            <h2>Configuración de Cuenta</h2>
            <ul>
                <li><a href="#">Actualizar Información Personal</a></li>
                <li><a href="#">Gestionar Trabajas</a></li>
                <li><a href="#">Preferencias de Notificación</a></li>
            </ul>
        </section>
    </div>
</body>
</html>
