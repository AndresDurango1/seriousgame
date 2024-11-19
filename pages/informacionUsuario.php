<?php
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['rol'] != 0 && $_SESSION['rol'] != 1)) {
    header("Location: ../pages/index.php");
    exit();
}
include_once '../php/conexion.php';
$conexion = conectar();
$id_administrador = $_SESSION['id_usuario'];
//consulta a la base de datos para traer la informacion del administrador para la Barra de navegacion
$stmt1 = $conexion->prepare("SELECT identificacion, nombre, apellido, correo, contrasena, id_imagen FROM usuarios WHERE id_usuario = ?");
$stmt1->bind_param("i", $id_administrador);
$stmt1->execute();
$resultado1 = $stmt1->get_result();
if ($resultado1->num_rows > 0) {
    $fila1 = $resultado1->fetch_assoc();
} else {
    echo "No se encontró información del administrador.";
    exit();
}
//Consulta a la base de datos para traer la imagen del administrador de la tabla imagenes
$stmtImagenAdmin = $conexion->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?");
$stmtImagenAdmin->bind_param("i", $fila1['id_imagen']);
$stmtImagenAdmin->execute();
$resultadoImagenAdmin = $stmtImagenAdmin->get_result();
if ($resultadoImagenAdmin->num_rows > 0) {
    $imagenAdmin = $resultadoImagenAdmin->fetch_assoc();
    $ruta_imagen_admin = $imagenAdmin['ruta_imagen'];
} else {
    echo "No se encontró la imagen del administrador.";
    exit();
}
//consulta a la base de datos para traer la informacion del usuario para la barra lateral
$id_user = $_GET['id_user'];
$stmt2 = $conexion->prepare("SELECT u.identificacion, u.usuario, u.nombre, u.apellido, u.correo, u.id_imagen, c.celular FROM usuarios u 
LEFT JOIN caracterizacion c ON u.id_usuario = c.id_usuario
WHERE u.id_usuario = ?");
$stmt2->bind_param("i", $id_user);
$stmt2->execute();
$resultado2 = $stmt2->get_result();
if ($resultado2->num_rows > 0) {
    $fila2 = $resultado2->fetch_assoc();
} else {
    echo "No se encontró información del usuario.";
    exit();
}
//Consulta a la base de datos para traer la imagen del usuario de la tabla imagenes
$stmtImagenUser = $conexion->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?");
$stmtImagenUser->bind_param("i", $fila2['id_imagen']);
$stmtImagenUser->execute();
$resultadoImagenUser = $stmtImagenUser->get_result();
if ($resultadoImagenUser->num_rows > 0) {
    $imagenUser = $resultadoImagenUser->fetch_assoc();
    $ruta_imagen_user = $imagenUser['ruta_imagen'];
} else {
    echo "No se encontró la imagen del usuario.";
    exit();
}
// Variables para la seccion de paginación de la tabla
$limit = 5; // Número de resultados por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Número de página actual
$offset = ($page - 1) * $limit; // Calcular el desplazamiento
// Consulta para obtener los niveles del usuario con limit y offset 
$stmtTabla = $conexion->prepare("SELECT nu.id_usuario, u.usuario AS usuario, nu.id_nivel, n.nombre_nivel AS nivel, nu.completado, nu.inicio, nu.fin, nu.tiempo_transcurrido, 
                            nu.puntaje FROM niveles_usuarios nu
                            JOIN 
                                usuarios u ON nu.id_usuario = u.id_usuario
                            JOIN 
                                niveles n ON nu.id_nivel = n.id_nivel 
                            WHERE nu.id_usuario = ?
                            LIMIT ? OFFSET ?");

$stmtTabla->bind_param("iii", $id_user, $limit, $offset);
$stmtTabla->execute();
$resultadoTabla = $stmtTabla->get_result();
// Consulta para contar el total de registros
$totalQuery = "SELECT COUNT(*) as total FROM niveles_usuarios WHERE id_usuario = ?";
$totalStmt = $conexion->prepare($totalQuery);
$totalStmt->bind_param("i", $id_user);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalUsers = $totalRow['total']; // Total de niveles del usuario
$totalPages = ceil($totalUsers / $limit); // Calcular el total de páginas
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/informacionUsuarioStyles.css">
    <title>Document</title>
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">Inicio</button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/estadisticas.php'">Ver Estadísticas</button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/administrador.php'">Volver</button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorInfoUsuario">
            <div class="contenedorIconoUsuario">
                <img class="iconoUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen_admin; ?>" alt="iconoUsuario">
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
    <main class="contenedorPrincipal">
        <aside class="barraLateral">
            <p class="barraLateralTitulo">@<?php echo htmlspecialchars($fila2['usuario']); ?></p>
            <div class="contenedorImagenUsuario">
                <img class="imagenUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen_user; ?>" alt="Imagen Usuario">
            </div>
            <div class="contenedorFormularioActualizacion">
                <form class="formularioActualizacion" action="../php/actualizarUsuario.php" method="post">
                    <label for="lbl-item" for="lblId" hidden>Id</label>
                    <input type="number" name="inputId" id="inputId" value="<?php echo $id_usuario; ?>" hidden>
                    <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                    <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" value="<?php echo htmlspecialchars($fila2['identificacion']); ?>" readonly>
                    <label class="lbl-item" for="lblNombre">Nombre</label>
                    <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo htmlspecialchars($fila2['nombre']); ?>" readonly>
                    <label class="lbl-item" for="lblApellido">Apellido</label>
                    <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo htmlspecialchars($fila2['apellido']); ?>" readonly>
                    <label class="lbl-item" for="lblCorreo">Correo</label>
                    <input class="input-item" type="text" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila2['correo']); ?>" readonly>
                    <label class="lbl-item" for="lblCelular">Celular</label>
                    <input class="input-item" type="text" name="inputCelular" id="inputCelular" value="<?php echo htmlspecialchars($fila2['celular']); ?>" readonly>
                </form>
            </div>
        </aside>
        <div class="contenedorPrincipal-content">
            <div class="contenedorTabla">
                <table class="tablaClasificacion">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nivel</th>
                            <th>Estado Nivel</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Tiempo transcurrido</th>
                            <th>Puntaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($fila = $resultadoTabla->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='informacionUsuario.php?id_usuario=" . $fila['id_usuario'] . "'>@" . $fila['usuario'] . "</a></td>";
                            echo "<td>" . $fila['nivel'] . "</td>";
                            echo "<td>" . ($fila['completado'] ? 'Completado' : 'No Completado') . "</td>";
                            echo "<td>" . $fila['inicio'] . "</td>";
                            echo "<td>" . $fila['fin'] . "</td>";
                            echo "<td>" . $fila['tiempo_transcurrido'] . "</td>";
                            echo "<td>" . $fila['puntaje'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="paginacion">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='?page=$i'>$i</a> ";
                    }
                    ?>
                </div>
            </div>
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active slide">
                        <!-- <img src="../recursos/img/imgPerfil/animados/animado1.jpg" alt=""> -->
                        <canvas class="grafico" id="myChart1"></canvas>
                    </div>
                    <div class="carousel-item slide">
                        <!-- <img src="../recursos/img/imgPerfil/animados/animado2.jpg" alt=""> -->
                        <canvas class="grafico" id="myChart2"></canvas>
                    </div>
                    <div class="carousel-item slide">
                        <!-- <img src="../recursos/img/imgPerfil/animados/animado3.jpg" alt=""> -->
                        <canvas class="grafico" id="myChart3"></canvas>
                    </div>
                    <div class="carousel-item slide">
                        <!-- <img src="../recursos/img/imgPerfil/animados/animado4.jpg" alt=""> -->
                        <canvas class="grafico" id="myChart4"></canvas>
                    </div>
                    <div class="carousel-item slide">
                        <!-- <img src="../recursos/img/imgPerfil/animados/animado5.jpg" alt=""> -->
                        <canvas class="grafico" id="myChart5"></canvas>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </main>
</body>

</html>