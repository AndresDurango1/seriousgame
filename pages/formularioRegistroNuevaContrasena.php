<?php
    session_start();
    include_once '../php/conexion.php';
    $conexion = conectar();
    if (isset($_SESSION['registro_identificacion'])) {
        $identificacionRegistro = $_SESSION['registro_identificacion'];
        //unset($_SESSION['registro_identificacion']);
    } else {
        echo "No se encontró información para el registro 1.";
    }

    $estaLogueado = isset($_SESSION['id_usuario']);
    if ($estaLogueado) { 
        $id_usuario = $_SESSION['id_usuario']; 
        $rol = $_SESSION['rol']; 
        $miPerfilUrl = ($rol == 1) ? '../pages/administrador.php' : '../pages/usuario.php'; 
        // Consulta a la base de datos para traer la información del usuario 
        $stmt1 = $conexion->prepare("SELECT identificacion, primer_nombre, primer_apellido, correo, contrasena, id_imagen FROM usuarios WHERE id_usuario = ?"); 
        $stmt1->bind_param("i", $id_usuario); $stmt1->execute(); 
        $resultado1 = $stmt1->get_result(); 
        if ($resultado1->num_rows > 0) { 
            $fila = $resultado1->fetch_assoc(); 
        } else { 
            echo "No se encontró información del usuario."; 
            exit(); 
        } 
        // Consulta a la base de datos para traer la imagen del usuario de la tabla imagenes 
        $stmtImagen = $conexion->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?"); 
        $stmtImagen->bind_param("i", $fila['id_imagen']); 
        $stmtImagen->execute(); $resultadoImagen = $stmtImagen->get_result(); 
        if ($resultadoImagen->num_rows > 0) { 
            $imagen = $resultadoImagen->fetch_assoc(); 
            $ruta_imagen = $imagen['ruta_imagen']; 
        } else { 
            echo "No se encontró la imagen del usuario."; exit(); 
        } 
    }
    // Consulta a la base de datos para traer la información de los campos del formulario de caracterización
    $stmtUsuario = $conexion->prepare("SELECT identificacion, CONCAT(primer_nombre, ' ', segundo_nombre) AS nombre_completo, CONCAT(primer_apellido, ' ', segundo_apellido) AS apellido_completo, correo FROM usuarios WHERE identificacion = ?");
    $stmtUsuario->bind_param("s", $identificacionRegistro);
    $stmtUsuario->execute();
    $resultUsuario = $stmtUsuario->get_result();
    if ($resultUsuario->num_rows > 0) {
        $usuario = $resultUsuario->fetch_assoc();
    } else {
        echo "No se encontró información del usuario. 2";
        exit();
    }
    $stmtCategorias = $conexion->prepare("SELECT DISTINCT id_categoria, categoria FROM categoria_imagenes ORDER BY categoria ASC");
    $stmtCategorias->execute();
    $resultadoCategorias = $stmtCategorias->get_result();
    $stmtImagenes = "SELECT * FROM imagenes";
    $resultImagenes = $conexion->query($stmtImagenes);
    $imagenesPorCategoria = [];
    while ($imagen = $resultImagenes->fetch_assoc()) {
        $imagenesPorCategoria[$imagen['id_categoria']][] = $imagen;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilosFormularioRegistroNuevaContrasena.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <title>Document</title>
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">Inicio 
            <i class="fas fa-home"id="iconoHome" style="color: #000000;"></i>
            </button>
            <button class="btnRedireccion" onclick="window.location.href='<?php echo $miPerfilUrl; ?>'">Mi perfil
            <i class="fa-solid fa-left-long" style="color: #000000;"></i>
            </button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorLista">
            <ol class="opcionesNavegacion">
                <li><a href="../pages/index.php#game-features" class="nav-link">Características del Juego</a>
                <i class="fas fa-puzzle-piece" id="iconoPuzzle" style="color: #ffffff;;"></i>                    
                </li>
                <li><a href="../pages/index.php#player-handbook" class="nav-link">Manual del Jugador</a>
                <i class="fas fa-gamepad" id="iconoGamepad" style="color: #ffffff;"></i>
                </li>
            </ol>
        </div>
    </nav>
    <div class="contenedorPrincipal">
        <div class="contenedorFormularioRegistro" id="contenedorFormularioRegistro">
            <form class="formularioRegistro" action="../php/registroNuevaContrasena.php" method="post">
                <h1 class="tituloFormularioRegistrarse">Completa tu Perfil</h1>
                <div class="contenedorInfoFormularioRegistro">
                    <div class="contenedorPage1">
                        <label class="lbl-item" for="lblImagenPerfil">Imagen de Perfil</label>
                        <select class="input-item" name="inputCategoriaImagenPerfil" id="inputCategoriaImagenPerfil" onchange="cargarImagenesPorCategoria()">
                            <option value="">Selecciona una Categoría</option>
                            <?php
                            while ($categoria = $resultadoCategorias->fetch_assoc()) {
                                echo "<option value='{$categoria['id_categoria']}'>{$categoria['categoria']}</option>";
                            }
                            ?>
                        </select>
                        <div class="contenedorImagenesCategoria" id="contenedorImagenesCategoria"></div>
                        <input class="input-item" name="inputIdImagenPerfil" id="inputIdImagenPerfil" value="87" required type="hidden">
                    </div>
                    <div class="contenedorPage2">
                        <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                        <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" value="<?php echo $usuario['identificacion']; ?>" readonly>
                        <label class="lbl-item" for="lblNombre">Nombre</label>
                        <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo $usuario['nombre_completo']; ?>" readonly>
                        <label class="lbl-item" for="lblApellido">Apellido</label>
                        <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo $usuario['apellido_completo']; ?>" readonly>
                        <label class="lbl-item" for="lblCorreo">Correo</label>
                        <input class="input-item" type="email" name="inputCorreo" id="inputCorreo" value="<?php echo $usuario['correo']; ?>" readonly>
                        <label class="lbl-item" for="lblContrasena">Contraseña</label>
                        <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" required>
                        <label class="lbl-item" for="lblConfirmarContrasena">Confirmar Contraseña</label>
                        <input class="input-item" type="password" name="inputConfirmarContrasena" id="inputConfirmarContrasena" placeholder="Confirma tu Contraseña" required>
                        <button class="btnEnviar" type="submit">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="contenedorVistaPrevia" id="contenedorVistaPrevia">
            <h1 class="titulo">Vista Previa de la Imagen Perfil</h1>
            <div class="contenedorImagenVistaPrevia">
                <img class="imgVistaPrevia" id="imgVistaPrevia" src="" alt="Vista previa de la imagen">
            </div>
        </div>
    </div>
    <script src="../js/vistaPreviaImagen.js"></script>
    <script src="../js/scriptAlertas.js"></script>
</body>

</html>