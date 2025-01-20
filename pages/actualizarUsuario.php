<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || ($_SESSION['rol'] != 0 && $_SESSION['rol'] != 1)) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
    if (isset($_GET['id_user'])) {
        $id_user = intval($_GET['id_user']);
        $stmt1 = $conexion->prepare("SELECT 
                                        u.id_usuario, 
                                        u.identificacion, 
                                        u.primer_nombre, 
                                        u.segundo_nombre, 
                                        u.primer_apellido, 
                                        u.segundo_apellido, 
                                        u.rol, 
                                        u.celular, 
                                        u.correo, 
                                        u.id_empresa, 
                                        u.id_canal,
                                        u.id_cargo, 
                                        u.id_regional, 
                                        u.id_ciudad, 
                                        u.id_segmento
                                    FROM usuarios u
                                    WHERE u.id_usuario = ? ");
                                    
        $stmt1->bind_param("i", $id_user);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1->num_rows > 0) {
            $fila = $result1->fetch_assoc();
        } else {
            echo "No se encontró información del usuario.";
            exit();
        }
    }
    else {  
        header("Location:../pages/administrarUsuarios.php?missing-id-user=true");
        exit();
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
    <link rel="stylesheet" href="../css/estilosFormularioActualizacion.css">
    <title>Document</title>
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
            <button class="btnRedireccion" onclick="window.location.href='../pages/administrarUsuarios.php'">
                Administrar Usuarios
            </button> 
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
            <div class="contenedorFormularioRegistro" id="contenedorFormularioRegistro">
                <form class="formularioRegistro" action="../php/actualizarUsuarioAdmon.php" method="post">
                    <h1 class="tituloFormularioRegistrarse">Actualización de Usuario</h1>
                    <div class="contenedorInfoFormularioRegistro">
                        <div class="contenedorPage1">
                            <input class="input-item" type="hidden" name="inputId" id="inputId" value="<?php echo $fila['id_usuario'];?>" readonly>
                            <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                            <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" value="<?php echo htmlspecialchars($fila['identificacion'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            <label class="lbl-item" for="lblPrimerNombre">Primer Nombre</label>
                            <input class="input-item" type="text" name="inputPrimerNombre" id="inputPrimerNombre" value="<?php echo htmlspecialchars($fila['primer_nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            <label class="lbl-item" for="lblSegundoNombre">Segundo Nombre</label>
                            <input class="input-item" type="text" name="inputSegundoNombre" id="inputSegundoNombre" value="<?php echo htmlspecialchars($fila['segundo_nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                            <label class="lbl-item" for="lblApellido">Primer Apellido</label>
                            <input class="input-item" type="text" name="inputPrimerApellido" id="inputPrimerApellido" value="<?php echo htmlspecialchars($fila['primer_apellido'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            <label class="lbl-item" for="lblApellido">Segundo Apellido</label>
                            <input class="input-item" type="text" name="inputSegundoApellido" id="inputSegundoApellido" value="<?php echo htmlspecialchars($fila['segundo_apellido'], ENT_QUOTES, 'UTF-8'); ?>">
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
                            <input class="input-item" type="text" name="inputCelular" id="inputCelular" value="<?php echo htmlspecialchars($fila['celular'], ENT_QUOTES, 'UTF-8'); ?>" required>                     
                            <label class="lbl-item" for="lblCorreo">Correo</label>
                            <input class="input-item" type="email" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            <label class="lbl-item" for="lblCorreo">Empresa</label>
                            <select class="input-item" name="inputEmpresa" id="inputEmpresa">
                                <option value="">Por favor selecciona una Empresa</option>
                                <?php
                                    foreach ($resultadoEmpresas as $empresa) {
                                        $selected = ($empresa['id_empresa'] == $fila['id_empresa']) ? 'selected' : '';
                                        echo "<option value=\"{$empresa['id_empresa']}\" $selected>{$empresa['empresa']}</option>";
                                    }
                                ?>
                            </select>
                            <label class="lbl-item" for="lblCanal">Canal</label>
                            <select class="input-item" name="inputCanal" id="inputCanal">
                                <option value="" selected>Por favor selecciona un Canal</option>
                                <?php
                                    foreach ($resultadoCanales as $canal) {
                                        $selected = ($canal['id_canal'] == $fila['id_canal']) ? 'selected' : '';
                                        echo "<option value=\"{$canal['id_canal']}\" $selected>{$canal['canal']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="contenedorPage3">
                            <label class="lbl-item" for="lblCargo">Cargo</label>
                            <select class="input-item" name="inputCargo" id="inputCargo">
                                <option value="" selected>Por favor selecciona un Cargo</option>
                                <?php
                                    foreach ($resultadoCargos as $cargo) {
                                        $selected = ($cargo['id_cargo'] == $fila['id_cargo']) ? 'selected' : '';
                                        echo "<option value=\"{$cargo['id_cargo']}\" $selected>{$cargo['cargo']}</option>";
                                    }
                                ?>
                            </select>
                            <label class="lbl-item" for="lblRegional">Regional</label>
                            <select class="input-item" name="inputRegional" id="inputRegional">
                                <option value="" selected>Por favor selecciona una Regional</option>
                                <?php
                                    foreach ($resultadoRegionales as $regional) {
                                        $selected = ($regional['id_regional'] == $fila['id_regional']) ? 'selected' : '';
                                        echo "<option value=\"{$regional['id_regional']}\" $selected>{$regional['regional']}</option>";
                                    }
                                ?>
                            </select>
                            <label class="lbl-item" for="lblCiudad">Ciudad</label>
                            <select class="input-item" name="inputCiudad" id="inputCiudad">
                                <option value="" selected>Por favor selecciona una Ciudad</option>
                                <?php
                                    foreach ($resultadoCiudades as $ciudad) {
                                        $selected = ($ciudad['id_ciudad'] == $fila['id_ciudad']) ? 'selected' : '';
                                        echo "<option value=\"{$ciudad['id_ciudad']}\" $selected>{$ciudad['ciudad']}</option>";
                                    }
                                ?>
                            </select>
                            <label class="lbl-item" for="lblSegmento">Segmento</label>
                            <select class="input-item" name="inputSegmento" id="inputSegmento">
                                <option value="" selected>Por favor selecciona un Segmento</option>
                                <?php
                                    foreach ($resultadoSegmentos as $segmento) {
                                        $selected = ($segmento['id_segmento'] == $fila['id_segmento']) ? 'selected' : '';
                                        echo "<option value=\"{$segmento['id_segmento']}\" $selected>{$segmento['segmento']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="btnEnviar" type="submit">Enviar</button>
                </form>
        </div>
    </div>
</body>
</html>