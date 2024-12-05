<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 1) {
    header("Location: ../pages/index.php");
    exit();
}
include_once '../php/conexion.php';
$conexion = conectar();
$id_usuario = $_SESSION['id_usuario'];
//consulta a la base de datos para traer la informacion del usuario
$stmt1 = $conexion->prepare("SELECT identificacion, nombre, apellido, correo, contrasena, id_imagen FROM usuarios WHERE id_usuario = ?");
$stmt1->bind_param("i", $id_usuario);
$stmt1->execute();
$resultado1 = $stmt1->get_result();
if ($resultado1->num_rows > 0) {
    $fila = $resultado1->fetch_assoc();
} else {
    echo "No se encontró información del usuario.";
    exit();
}
//Consulta a la base de datos para traer la imagen del usuario de la tabla imagenes
$stmtImagen = $conexion->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?");
$stmtImagen->bind_param("i", $fila['id_imagen']);
$stmtImagen->execute();
$resultadoImagen = $stmtImagen->get_result();
if ($resultadoImagen->num_rows > 0) {
    $imagen = $resultadoImagen->fetch_assoc();
    $ruta_imagen = $imagen['ruta_imagen'];
} else {
    echo "No se encontró la imagen del usuario.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://unpkg.com/pdf-lib"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/estadisticasStyles.css">
</head>

<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">
                Inicio
                <i class="fas fa-home"id="iconoHome" style="color: #000000; "></i>
            </button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/formularioCaracterizacion.php'">
                Formulario Caracterización
                <i class="fab fa-wpforms" id="iconoFormularioCaracterizacion" style="color: #000000; "></i>
            </button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/administrador.php'">
                Volver
                <i class="fa-solid fa-left-long" style="color: #000000;"></i>
            </button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorInfoUsuario">
            <div class="contenedorIconoUsuario">
                <img class="iconoUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen; ?>" alt="iconoUsuario">
            </div>
            <div class="contenedorNombreUsuario">
                <p class="nombreUsuario"><?php echo "@" . $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <div class="contenedorIconos">
            <div class="contenedorIconoNuevoUsuario">
                <a href="../pages/formularioRegistroUsuario.php">
                    <i class="fas fa-user-plus" style="color: #ffffff;"></i>
                </a>
            </div>
            <div class="contenedorIconoSalir">
                <a href="../php/cerrarSesion.php">
                    <i class="fas fa-sign-out-alt" style="color: #ffffff;"></i>
                </a>
            </div>
        </div>
    </nav>
    <div class="contenedorPrincipal">
        <section class="descripcionPagina">
            <div class="contenedorInfoSeccion">
                <p class="infoSeccion">
                    ¡Bienvenido a la página de estadísticas del juego! Aquí podrás encontrar una variedad de gráficos e información que destacan el rendimiento de los jugadores y datos demográficos de nuestra comunidad. Explora y descubre quiénes son los mejores jugadores, los récords de menores tiempos y mucho más.
                    Estas estadísticas no solo reflejan el rendimiento y las características de nuestros jugadores, sino que también nos ayudan a entender mejor a nuestra comunidad para seguir mejorando la experiencia del juego. ¡Gracias por ser parte de nuestra comunidad!
                </p>
            </div>
        </section>
        <button id="generatePDFButton">Generar PDF Global</button>
        <section class="seccionRendimientoJuego">
            <p class="infoSeccion" >En esta sección, presentamos:</p>
            <div class="contenedorLista">
                <ul class="listaRendimientoJuego">
                    <li>Top-10 Jugadores: Un ranking de los 10 jugadores con los puntajes acumulados más altos.</li>
                    <li>Top-10 Jugadores: Un ranking de los 10 jugadores con los puntajes acumulados más bajos.</li>
                    <li>Top-10 Puntaje Promedio: Un ranking con los 10 promedios de puntaje por nivel mas alto.</li>
                    <li>Top-10 Tiempo: Un ranking de los 10 tiempos más rápidos logrados en distintos niveles del juego.</li>
                </ul>
            </div>
            <div class="contenedorGraficosRendimiento">
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart1"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart2"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart3"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart4"></canvas>
                </div>
            </div>
        </section>
        <section class="seccionInformacionDemografica">
            <p class="infoSeccion">En esta sección, presentamos:</p>
            <div class="contenedorLista">
                <ul class="listaInformacionDemografica">
                    <li>Distribucion de género: Gráficos que muestran los géneros de nuestros jugadores.</li>
                    <li>Distribución de edades: Gráficos que muestran las edades de nuestros jugadores.</li>
                    <li>Diversidad geográfica: Información sobre las regiones y países de donde provienen nuestros jugadores.</li>
                </ul>
            </div>
            <div class="contenedorGraficosInformacionDemografica">
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart5"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart6"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart7"></canvas>
                </div>
                <div class="contenedorGrafico">
                    <canvas class="grafico" id="myChart8"></canvas>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/scriptGenerarGraficosEstadisticas.js"></script>
    <script type="module" src="../js/scriptGenerarReporteGlobal.js"></script>
</body>
</html>