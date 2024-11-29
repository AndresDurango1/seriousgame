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
// Variables para la seccion de paginación de la tabla
$limit = 5; // Número de resultados por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
// Consulta para obtener todos los niveles de todos los usuario con limit y offset 
$stmt2 = $conexion->prepare("SELECT nu.id_usuario, u.usuario AS usuario, nu.id_nivel, n.nombre_nivel AS nivel, nu.completado, nu.inicio, nu.fin, nu.tiempo_transcurrido, 
                            nu.puntaje FROM niveles_usuarios nu
                            JOIN 
                                usuarios u ON nu.id_usuario = u.id_usuario
                            JOIN 
                                niveles n ON nu.id_nivel = n.id_nivel
                            ORDER BY nu.id_usuario ASC, nu.id_nivel ASC 
                            LIMIT ? OFFSET ?");

$stmt2->bind_param("ii", $limit, $offset);
$stmt2->execute();
$resultado2 = $stmt2->get_result();
// Consulta para contar el total de registros
$totalQuery = "SELECT COUNT(*) as total FROM niveles_usuarios";
$totalStmt = $conexion->prepare($totalQuery);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <!-- <link rel="stylesheet" href="../css/usuarioStyles.css"> -->

    <link rel="stylesheet" href="../css/styleresponsive.css">

     <link rel="stylesheet" href="../css/administradorStyles.css">
</head>

<body>
<nav class="barraNavegacion">
    <!-- Contenido existente -->
    <div class="menu-toggle" id="menu-toggle">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <div class="contenedorBotonesRedireccion" id="nav-links">
        <!-- Botones existentes -->
        <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">Inicio</button>
        <span><i class="fas fa-home" id="iconoHome" style="color: #ffffff;"></i></span>
        <button class="btnRedireccion" onclick="abrirModal()">Actualizar Perfil</button>
        <span><i class="fas fa-user-edit" style="color: #ffffff;"></i></span>
    </div>

    <!-- Modal para actualizar perfil -->
<div id="modalActualizarPerfil" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="cerrarModal()">&times;</span>
        <p class="barraLateralTitulo">Actualizar mi perfil</p>
        <div class="contenedorImagenUsuario">
            <img class="imagenUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen; ?>" alt="Imagen Usuario">
        </div>
        <div class="contenedorFormularioActualizacion">
            <!-- Reutilizar el formulario actual -->
            <form class="formularioActualizacion" action="../php/actualizarUsuario.php" method="post">
                <input type="number" name="inputId" id="inputId" value="<?php echo $id_usuario; ?>" hidden>
                <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" value="<?php echo htmlspecialchars($fila['identificacion']); ?>" readonly>
                <label class="lbl-item" for="lblNombre">Nombre</label>
                <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>">
                <label class="lbl-item" for="lblApellido">Apellido</label>
                <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo htmlspecialchars($fila['apellido']); ?>">
                <label class="lbl-item" for="lblCorreo">Correo</label>
                <input class="input-item" type="text" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila['correo']); ?>">
                <label class="lbl-item" for="lblContrasena">Contraseña</label>
                <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Nueva Contraseña">
                <label class="lbl-item" for="lblConfirmarContrasena">Confirmar Contraseña</label>
                <input class="input-item" type="password" name="inputConfirmarContrasena" id="inputConfirmarContrasena" placeholder="Confirma tu Nueva Contraseña">
                <button class="btnActualizar" type="submit">ACTUALIZAR</button>
            </form>
        </div>
    </div>
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
        <aside class="barraLateral">
            <p class="barraLateralTitulo">Actualizar mi perfil</p>
            <div class="contenedorImagenUsuario">
                <img class="imagenUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen; ?>" alt="Imagen Usuario">
            </div>
            <div></div>
            <div class="contenedorFormularioActualizacion">
                <form class="formularioActualizacion" action="../php/actualizarUsuario.php" method="post">
                    <label for="lbl-item" for="lblId" hidden>Id</label>
                    <input type="number" name="inputId" id="inputId" value="<?php echo $id_usuario; ?>" hidden>
                    <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                    <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" value="<?php echo htmlspecialchars($fila['identificacion']); ?>" readonly>
                    <label class="lbl-item" for="lblNombre">Nombre</label>
                    <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>">
                    <label class="lbl-item" for="lblApellido">Apellido</label>
                    <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo htmlspecialchars($fila['apellido']); ?>">
                    <label class="lbl-item" for="lblCorreo">Correo</label>
                    <input class="input-item" type="text" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila['correo']); ?>">
                    <label class="lbl-item" for="lblContrasena">Contraseña</label>
                    <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Nueva Contraseña">
                    <label class="lbl-item" for="lblConfirmarContrasena">Confirmar Contraseña</label>
                    <input class="input-item" type="password" name="inputConfirmarContrasena" id="inputConfirmarContrasena" placeholder="Confirma tu Nueva Contraseña">
                    <button class="btnActualizar" type="submit">ACTUALIZAR</button>
                </form>
            </div>
        </aside>
        <div class="contenedorPrincipal-content">
            <?php
            // Consulta a la base de datos para obtener los tres mejores puntajes
            $query = "SELECT i.ruta_imagen, u.usuario, SUM(nu.puntaje) AS puntaje_total FROM usuarios u
                      JOIN 
                        niveles_usuarios nu ON u.id_usuario = nu.id_usuario
                      JOIN 
                        imagenes i ON u.id_imagen = i.id_imagen
                      GROUP BY u.id_usuario
                      ORDER BY puntaje_total DESC LIMIT 3";
            $result = $conexion->query($query);
            // Arrays para los estilos y posiciones
            $lugares = ["primero", "segundo", "tercero"];
            $posiciones = ["1st", "2nd", "3rd"];
            // Iniciar el contenedor de ranking
            echo '<div class="contenedorRanking">
                    <div class="ranking">';
                        $i = 0;
                        while ($fila = $result->fetch_assoc()) {
                            $ruta_imagen = $fila['ruta_imagen'];
                            $usuario = $fila['usuario'];
                            $puntaje = $fila['puntaje_total'];
                            $lugar = $lugares[$i];
                            $posicion = $posiciones[$i];
                            echo "<div class='ranking-item $lugar'>
                                    <div class='ranking-content'>
                                        <div class='ranking-img'>
                                            <img src='../recursos/img/imgPerfil/$ruta_imagen' alt='Jugador $posicion'>
                                        </div>
                                        <div class='ranking-text'>
                                            <p>@$usuario</p>
                                            <p>$posicion</p>
                                            <p>$puntaje Puntos</p>
                                        </div>

                                    </div>
                                </div>";
                            $i++;
                        }
            echo '</div></div>';
            ?>
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
                        while ($fila = $resultado2->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='informacionUsuario.php?id_user=" . $fila['id_usuario'] . "'>@" . $fila['usuario'] . "</a></td>";
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
        </div>
    </div>
    <script src="../js/scriptAdmin.js"></script>
    <script src="../js/scriptAlertas.js"></script>
</body>

</html>