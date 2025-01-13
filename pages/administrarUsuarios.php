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
    $stmt1 = $conexion->prepare("SELECT identificacion, CONCAT(primer_nombre,' ',segundo_nombre) AS nombre_completo, CONCAT(primer_apellido,' ',segundo_apellido) AS apellido_completo, correo, contrasena, id_imagen FROM usuarios WHERE id_usuario = ?");
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
    $limit = 12; // Número de resultados por página
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    //Consulta a la base de datos para traer todos los usuarios excepto el administrador
    $stmt2 = $conexion->prepare("SELECT u.id_usuario, u.identificacion, CONCAT(u.primer_nombre,' ',u.segundo_nombre) AS nombre_completo, CONCAT(u.primer_apellido,' ',u.segundo_apellido) AS apellido_completo, CASE u.rol WHEN 0 THEN 'Colaborador' ELSE u.rol END AS rol, u.celular, LOWER(u.correo) AS correo 
    FROM usuarios u 
    WHERE rol!= 1
    ORDER BY apellido_completo ASC
    LIMIT ? OFFSET ?");
    $stmt2->bind_param("ii", $limit, $offset);
    $stmt2->execute();
    $resultado2 = $stmt2->get_result();
    // Consulta para contar el total de registros
    $totalQuery = "SELECT COUNT(*) as total FROM usuarios WHERE rol!= 1";
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
    <link rel="stylesheet" href="../css/administrarUsuariosStyles.css">
    <title>Administrar Usuarios</title>
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">
                Inicio
                <i class="fas fa-home" id="iconoHome" style="color: #000000;"></i>
            </button>
            <!-- <button class="btnRedireccion" onclick="window.location.href='../pages/formularioCaracterizacion.php'">
                Formulario Caracterización
                <i class="fab fa-wpforms" id="iconoFormularioCaracterizacion" style="color:#000000"></i>
                <i class="fa-solid fa-turn-down fa-rotate-90"></i>
            </button> -->
            <!-- <button class="btnRedireccion" onclick="window.location.href='../pages/administrarUsuarios.php'">
                Administrar Usuarios
            </button>  -->
            <button class="btnRedireccion" onclick="window.location.href='../pages/estadisticas.php'">
                Ver Estadísticas
                <i class="fas fa-signal" id="iconoEstadisticas" style="color: #000000;"></i>
            </button>
            <button class="btnRedireccion btnMenuHamburguesa" id="btnMenuHamburguesa">
                <i class="fas fa-bars" id="iconoMenuHamburguesa"></i>
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
                <p class="nombreUsuario"><?php echo "@" . $_SESSION['identificacion']; ?></p>
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
        <aside class="barraLateral" id="barraLateral">
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
                    <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo htmlspecialchars($fila['nombre_completo']); ?>">
                    <label class="lbl-item" for="lblApellido">Apellido</label>
                    <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo htmlspecialchars($fila['apellido_completo']); ?>">
                    <label class="lbl-item" for="lblCorreo">Correo</label>
                    <input class="input-item" type="text" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila['correo']); ?>">
                    <label class="lbl-item" for="lblContrasena">Contraseña</label>
                    <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Nueva Contraseña">
                    <label class="lbl-item" for="lblConfirmarContrasena">Confirmar Contraseña</label>
                    <input class="input-item" type="password" name="inputConfirmarContrasena" id="inputConfirmarContrasena" placeholder="Confirma tu Nueva Contraseña">
                    <button class="btnActualizar" type="submit">Actualizar</button>
                </form>
            </div>
        </aside>
        <div class="contenedorPrincipalContent">
            <div class="contenedorTabla">
                <input type="text" id="searchInput" placeholder="Buscar en la tabla..." onkeyup="filtrarTabla()">
                <table class="tablaUsuarios" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Identificacion</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th>Rol</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($fila = $resultado2->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='informacionUsuario.php?id_user=" . $fila['id_usuario'] . "'>" . $fila['identificacion'] . "</a></td>";
                            echo "<td>" . $fila['apellido_completo'] . "</td>";
                            echo "<td>" . $fila['nombre_completo'] . "</td>";
                            echo "<td>" . $fila['rol'] . "</td>";
                            echo "<td>" . $fila['celular'] . "</td>";
                            echo "<td>" . $fila['correo'] . "</td>";
                            echo "<td>";
                                echo "<a href='actualizarUsuario.php?id_user=" . $fila['id_usuario'] . "' class='btnAccion btnActualizar'>Actualizar</a>";
                                echo "<a href='eliminarUsuario.php?id_user=" . $fila['id_usuario'] . "' class='btnAccion btnEliminar' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\");'>Eliminar</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="paginacion">
                    <?php
                    $visiblePages = 5;
                    $startPage = max(1, $page - floor($visiblePages / 2));
                    $endPage = min($totalPages, $startPage + $visiblePages - 1);
                    if ($endPage - $startPage < $visiblePages - 1) {
                        $startPage = max(1, $endPage - $visiblePages + 1);
                    }
                    if ($page > 1) {
                        echo "<a href='?page=1'>&laquo; Primera Página</a>";
                        echo "<a href='?page=" . ($page - 1) . "'><<</a>";
                    }
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        if ($i == $page) {
                            echo "<span class='pagina-actual'>$i</span>";
                        } else {
                            echo "<a href='?page=$i'>$i</a>";
                        }
                    }
                    if ($page < $totalPages) {
                        echo "<a href='?page=" . ($page + 1) . "'>>></a>";
                        echo "<a href='?page=$totalPages'>Última Página &raquo;</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/scriptFiltrarUsuarios.js"></script>
</body>
</html>