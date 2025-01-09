<?php
    session_start();
    $estaLogueado = isset($_SESSION['id_usuario']);
    include_once '../php/conexion.php';
    $conexion = conectar();
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
    // Consulta a la base de datos para traer la información de los campos select del formulario de registro
    $stmtEmpresas = $conexion->prepare("SELECT id_empresa, empresa FROM empresas");
    $stmtEmpresas->execute();
    $resultadoEmpresas = $stmtEmpresas->get_result();

    $stmtCanales = $conexion->prepare("SELECT id_canal, canal FROM canales");
    $stmtCanales->execute();
    $resultadoCanales = $stmtCanales->get_result();

    $stmtCargos = $conexion->prepare("SELECT id_cargo, cargo FROM cargos");
    $stmtCargos->execute();
    $resultadoCargos = $stmtCargos->get_result();

    $stmtRegionales = $conexion->prepare("SELECT id_regional, regional FROM regionales");
    $stmtRegionales->execute();
    $resultadoRegionales = $stmtRegionales->get_result();

    $stmtCiudades = $conexion->prepare("SELECT id_ciudad, ciudad FROM ciudades");
    $stmtCiudades->execute();
    $resultadoCiudades = $stmtCiudades->get_result();

    $stmtSegmentos = $conexion->prepare("SELECT id_segmento, segmento FROM segmentos");
    $stmtSegmentos->execute();
    $resultadoSegmentos = $stmtSegmentos->get_result();

    // Cerrar la conexión a la base de datos
    $conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilosFormularioRegistro.css">
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
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <h1 class="tituloFormularioRegistrarse">Registro de Usuario Nuevo</h1>
                <div class="contenedorInfoFormularioRegistro">
                    <div class="contenedorPage1">
                        <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                        <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Identificación" required>
                        <label class="lbl-item" for="lblPrimerNombre">Primer Nombre</label>
                        <input class="input-item" type="text" name="inputPrimerNombre" id="inputPrimerNombre" placeholder="Ingresa el Primer Nombre" required>
                        <label class="lbl-item" for="lblSegundoNombre">Segundo Nombre</label>
                        <input class="input-item" type="text" name="inputSegundoNombre" id="inputSegundoNombre" placeholder="Ingresa el Segundo Nombre (Opcional)">
                        <label class="lbl-item" for="lblApellido">Primer Apellido</label>
                        <input class="input-item" type="text" name="inputPrimerApellido" id="inputPrimerApellido" placeholder="Ingresa el Primer Apellido" required>
                        <label class="lbl-item" for="lblApellido">Segundo Apellido</label>
                        <input class="input-item" type="text" name="inputSegundoApellido" id="inputSegundoApellido" placeholder="Ingresa el Segundo Apellido (Opcional)">
                    </div>
                    <div class="contenedorPage2">
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                            <label class="lbl-item" for="lblRol">Rol</label>
                            <select class="input-item" name="inputRol" id="inputRol">
                                <option>Selecciona un Rol</option>
                                <option value="0">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                        <?php endif; ?>
                        <label class="lbl-item" for="lblCelular">Celular</label>
                        <input class="input-item" type="text" name="inputCelular" id="inputCelular" placeholder="Ingresa el Número de Línea Móvil" required>                     
                        <label class="lbl-item" for="lblCorreo">Correo</label>
                        <input class="input-item" type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" required>
                        <label class="lbl-item" for="lblCorreo">Empresa</label>
                        <select class="input-item" name="inputEmpresa" id="inputEmpresa">
                            <option value="" selected>Por favor selecciona una Empresa</option>
                            <?php while ($row = $resultadoEmpresas->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_empresa']; ?>">
                                    <?php echo htmlspecialchars($row['empresa'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="lbl-item" for="lblCorreo">Canal</label>
                        <select class="input-item" name="inputCanal" id="inputCanal">
                            <option value="" selected>Por favor selecciona un Canal</option>
                            <?php while ($row = $resultadoCanales->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_canal']; ?>">
                                    <?php echo htmlspecialchars($row['canal'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="contenedorPage3">
                        <label class="lbl-item" for="lblCorreo">Cargo</label>
                        <select class="input-item" name="inputCargo" id="inputCargo">
                            <option value="" selected>Por favor selecciona un Cargo</option>
                            <?php while ($row = $resultadoCargos->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_cargo']; ?>">
                                    <?php echo htmlspecialchars($row['cargo'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="lbl-item" for="lblCorreo">Regional</label>
                        <select class="input-item" name="inputRegional" id="inputRegional">
                            <option value="" selected>Por favor selecciona una Regional</option>
                            <?php while ($row = $resultadoRegionales->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_regional']; ?>">
                                    <?php echo htmlspecialchars($row['regional'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="lbl-item" for="lblCorreo">Ciudad</label>
                        <select class="input-item" name="inputCiudad" id="inputCiudad">
                            <option value="" selected>Por favor selecciona una Ciudad</option>
                            <?php while ($row = $resultadoCiudades->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_ciudad']; ?>">
                                    <?php echo htmlspecialchars($row['ciudad'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label class="lbl-item" for="lblCorreo">Fecha de Contratación</label>
                        <input class="input-item" type="date" name="inputFechaContratacion" id="inputFechaContratacion" placeholder="Ingresa tu Correo" required>
                        <label class="lbl-item" for="lblCorreo">Segmento</label>
                        <select class="input-item" name="inputSegmento" id="inputSegmento">
                            <option value="" selected>Por favor selecciona un Segmento</option>
                            <?php while ($row = $resultadoSegmentos->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_segmento']; ?>">
                                    <?php echo htmlspecialchars($row['segmento'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button class="btnEnviar" type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <script src="../js/vistaPreviaImagen.js"></script>
    <script src="../js/scriptAlertas.js"></script>
</body>
</html>