<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 0) {
    header("Location: ../pages/index.php");
    exit();
}
include_once '../php/conexion.php';
$conexion = conectar();
$id_usuario = $_SESSION['id_usuario'];
//consulta a la base de datos para traer la informacion del usuario
$stmt1 = $conexion->prepare("SELECT identificacion, nombre, apellido, correo, contrasena FROM usuarios WHERE id_usuario = ?");
$stmt1->bind_param("i", $id_usuario);
$stmt1->execute();
$resultado1 = $stmt1->get_result();
if ($resultado1->num_rows > 0) {
    $fila = $resultado1->fetch_assoc();
} else {
    echo "No se encontró información del usuario.";
    exit();
}
// Variables para la seccion de paginación de la tabla
$limit = 5; // Número de resultados por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Número de página actual
$offset = ($page - 1) * $limit; // Calcular el desplazamiento
// Consulta para obtener los niveles del usuario con limit y offset 
$stmt2 = $conexion->prepare("SELECT nu.id_usuario, u.usuario AS usuario, nu.id_nivel, n.nombre_nivel AS nivel, nu.completado, nu.inicio, nu.fin, nu.tiempo_transcurrido, 
                            nu.puntaje FROM niveles_usuarios nu
                            JOIN 
                                usuarios u ON nu.id_usuario = u.id_usuario
                            JOIN 
                                niveles n ON nu.id_nivel = n.id_nivel 
                            WHERE nu.id_usuario = ?
                            LIMIT ? OFFSET ?");

$stmt2->bind_param("iii", $id_usuario, $limit, $offset);
$stmt2->execute();
$resultado2 = $stmt2->get_result();
// Consulta para contar el total de registros
$totalQuery = "SELECT COUNT(*) as total FROM niveles_usuarios WHERE id_usuario = ?";
$totalStmt = $conexion->prepare($totalQuery);
$totalStmt->bind_param("i", $id_usuario);
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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/usuarioStyles.css">
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnonRedireccion" onclick="window.location.href='../pages/index.php'">HOME</button>
            <button class="botonRedireccion" onclick="window.location.href='../pages/index.php'">HOME</button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorInfoUsuario">
            <div class="contenedorIconoUsuario">
                <img class="iconoUsuario" src="../recursos/img/iconoScroll.png" alt="iconoUsuario">
            </div>
            <div class="contenedorNombreUsuario">
                <p class="nombreUsuario"><?php echo "@". $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <div class="contenedorIconoSalir">
            <i class="fas fa-sign-out-alt" style="color: #ffffff;"></i>
        </div>
    </nav>
    <div class="contenedorPrincipal">
        <aside class="barraLateral">
            <p class="barraLateralTitulo">Mi perfil</p>
            <div class="contenedorImagenUsuario">
                <img class="imagenUsuario" src="../recursos/img/iconoScroll.png" alt="Imagen Usuario">
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
            <div class="contenedorRanking">
                <div class="ranking">
                    <div class="ranking-item tercero">
                        <div class="ranking-content">
                            <img src="../recursos/img/iconoScroll.png" alt="Jugador 3">
                            <p>@SkyW</p>
                            <p>2nd</p>
                            <p>1234 votes</p>
                        </div>
                    </div>
                    <div class="ranking-item primero">
                        <div class="ranking-content">
                            <img src="../recursos/img/iconoScroll.png" alt="Jugador 1">
                            <p>@Aethr</p>
                            <p>1st</p>
                            <p>1234 votes</p>
                        </div>
                    </div>
                    <div class="ranking-item segundo">
                        <div class="ranking-content">
                            <img src="../recursos/img/iconoScroll.png" alt="Jugador 2">
                            <p>@Elmnt</p>
                            <p>3rd</p>
                            <p>1234 votes</p>
                        </div>
                    </div>
                </div>
            </div>
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
                            echo "<td>" ."@". $fila['usuario'] . "</td>";
                            echo "<td>" . $fila['nivel'] . "</td>";
                            echo "<td>" . ($fila['completado'] ? 'Completado' : 'No Completado') . "</td>";
                            echo "<td>" . $fila['inicio']."</td>";
                            echo "<td>" . $fila['fin']."</td>";
                            echo "<td>" . $fila['tiempo_transcurrido'] . "</td>";
                            echo "<td>" . $fila['puntaje'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="paginacion">
                    <?php
                        for ($i = 1; $i <= $totalPages; $i++) 
                        {
                            echo "<a href='?page=$i'>$i</a> ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/scriptAlertas.js"></script>
</body>
</html>
