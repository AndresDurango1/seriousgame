<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || ($_SESSION['rol'] != 0 && $_SESSION['rol'] != 1)) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
    $id_usuario = $_SESSION['id_usuario'];
    $rol = $_SESSION['rol'];
    $miPerfilUrl = ($rol == 1) ? '../pages/administrador.php' : '../pages/usuario.php';
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
    //consulta a la base de datos para traer la informacion de los campos select del formulario de caracterización
    //consulta a la base de datos para traer la informacion del genero
    $stmtGenero = $conexion->prepare("SELECT id_genero, genero FROM generos");
    $stmtGenero->execute();
    $resultadoGenero = $stmtGenero->get_result();
    //consulta a la base de datos para traer la informacion del grupo etnico
    $stmtGrupoEtnico = $conexion->prepare("SELECT id_grupo_etnico, grupo_etnico FROM grupo_etnico");
    $stmtGrupoEtnico->execute();
    $resultadoGrupoEtnico = $stmtGrupoEtnico->get_result();
    //consulta a la base de datos para traer la informacion del departamento
    $stmtDepartamento = $conexion->prepare("SELECT id_departamento, departamento FROM departamentos");
    $stmtDepartamento->execute();
    $resultadoDepartamento = $stmtDepartamento->get_result();
    //consulta a la base de datos para traer la informacion estado civil
    $stmtEstadoCivil = $conexion->prepare("SELECT id_estado_civil, estado_civil FROM estado_civil");
    $stmtEstadoCivil->execute();    
    $resultadoEstadoCivil = $stmtEstadoCivil->get_result();
    //consulta a la base de datos para traer la informacion del nivel educativo
    $stmtNivelEducativo = $conexion->prepare("SELECT id_nivel_educativo, nivel_educativo FROM nivel_educativo");
    $stmtNivelEducativo->execute();    
    $resultadoNivelEducativo = $stmtNivelEducativo->get_result();
    //consulta a la base de datos para traer la informacion de la ocupacion
    $stmtOcupacion = $conexion->prepare("SELECT id_ocupacion, ocupacion FROM ocupacion");
    $stmtOcupacion->execute();    
    $resultadoOcupacion = $stmtOcupacion->get_result();
    //consulta a la base de datos para traer la informacion del cargo
    $stmtCargo = $conexion->prepare("SELECT id_cargo, cargo FROM cargo");
    $stmtCargo->execute();    
    $resultadoCargo = $stmtCargo->get_result();
    //consulta a la base de datos para traer la informacion del estrato
    $stmtEstrato = $conexion->prepare("SELECT id_estrato, estrato FROM estrato");
    $stmtEstrato->execute();
    $resultadoEstrato = $stmtEstrato->get_result();
    //consulta a la base de datos para traer la informacion del tipo de vivienda
    $stmtTipoVivienda = $conexion->prepare("SELECT id_tipo_vivienda, tipo_vivienda FROM tipo_vivienda");
    $stmtTipoVivienda->execute();
    $resultadoTipoVivienda = $stmtTipoVivienda->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Caracterización</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/formularioCaracterizacionStyles.css">
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">Inicio
            </button>
            <button class="btnRedireccion" onclick="window.location.href='<?php echo $miPerfilUrl; ?>'">Mi perfil
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
                <p class="nombreUsuario"><?php echo "@". $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <div class="contenedorIconoSalir">
            <a href="../php/cerrarSesion.php">
                <i class="fas fa-sign-out-alt" style="color: #ffffff;"></i>
            </a>
        </div>
    </nav>
    <div class="contenedorPrincipal">
        <div class="contenedorIconoMenuHamburguesa">
            <button class ="btnMenuHamburguesa" id="btnMenuHamburguesa">
                <i class="fas fa-bars" id="iconoMenuHamburguesa"></i>
            </button>
        </div>
        <aside class="barraLateral" id="barraLateral">
            <p class="barraLateralTitulo">Mi perfil</p>
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
                    <input class="input-item" type="text" name="inputNombre" id="inputNombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" readonly>
                    <label class="lbl-item" for="lblApellido">Apellido</label>
                    <input class="input-item" type="text" name="inputApellido" id="inputApellido" value="<?php echo htmlspecialchars($fila['apellido']); ?>" readonly>
                    <label class="lbl-item" for="lblCorreo">Correo</label>
                    <input class="input-item" type="text" name="inputCorreo" id="inputCorreo" value="<?php echo htmlspecialchars($fila['correo']); ?>" readonly>
                </form>
            </div>
        </aside>
        <div class="contenedorPrincipal-content" id="contenedorPrincipal-content">
            <h1>Formulario de Caracterización Sociodemográfica</h1>
            <div class="contenedorFormularioCaracterizacion">
                <form class="formularioCaracterizacion" action="../php/caracterizacion.php" method="post">
                    <div class="contenedorInfoFormularioCaracterizacion">
                        <div class="contenedorPage1">
                            <label class="lbl-item" for="lblfechaNacimiento">Fecha de Nacimiento</label>
                            <input class="input-item" type="date" name="inputFechaNacimiento" id="inputFechaNacimiento" required>
                            <label class="lbl-item" for="lblGenero">Género</label>
                            <select class="input-item" name="inputGenero" id="inputGenero" required>
                                <option value="" disabled selected>Por favor selecciona una opción</option>
                                <?php while ($row = $resultadoGenero->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_genero']; ?>">
                                <?php echo htmlspecialchars($row['genero']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblgrupoEtnico">Grupo Etnico</label>
                            <select class="input-item" name="inputGrupoEtnico" id="inputGrupoEtnico" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoGrupoEtnico->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_grupo_etnico']; ?>">
                                <?php echo htmlspecialchars($row['grupo_etnico']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblnumeroCelular">Número de Celular</label>
                            <input class="input-item" type="text" name="inputNumeroCelular" id="inputNumeroCelular" required>
                            <label class="lbl-item" for="lblidUsuario" hidden>Id Usuario</label>
                            <input class="input-item" type="number" name="inputIdUsuario" id="inputIdUsuario" value="<?php echo $id_usuario; ?>" hidden>
                            <label class="lbl-item" for="lblDepartamento">Departamento</label>
                            <select class="input-item" name="inputDepartamento" id="inputDepartamento" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoDepartamento->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_departamento']; ?>">
                                <?php echo htmlspecialchars($row['departamento']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblCiudad">Ciudad</label></label>
                            <select class="input-item" name="inputCiudad" id="inputCiudad" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                            </select>
                        </div>
                        <div class="contenedorPage2">
                            <label class="lbl-item" for="lblestadoCivil">Estado Civil</label>
                            <select class="input-item" name="inputEstadoCivil" id="inputEstadoCivil" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoEstadoCivil->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_estado_civil']; ?>">
                                <?php echo htmlspecialchars($row['estado_civil']); ?>
                                    </option>
                                <?php endwhile; ?>

                            </select>
                            <label class="lbl-item" for="lblnivelEducativo">Nivel de Estudios</label>
                            <select class="input-item" name="inputNivelEducativo" id="inputNivelEducativo" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoNivelEducativo->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_nivel_educativo']; ?>">
                                <?php echo htmlspecialchars($row['nivel_educativo']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblOcupacion">Ocupacion</label>
                            <select class="input-item" name="inputOcupacion" id="inputOcupacion" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoOcupacion->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_ocupacion']; ?>">
                                <?php echo htmlspecialchars($row['ocupacion']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblCargo">Cargo</label>
                            <select class="input-item" name="inputCargo" id="inputCargo" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoCargo->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_cargo']; ?>">
                                <?php echo htmlspecialchars($row['cargo']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lblEstrato">Estrato</label>
                            <select class="input-item" name="inputEstrato" id="inputEstrato" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoEstrato->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_estrato']; ?>">
                                <?php echo htmlspecialchars($row['estrato']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <label class="lbl-item" for="lbltipoVivienda">Tipo de Vivienda</label>
                            <select class="input-item" name="inputTipoVivienda" id="inputTipoVivienda" required>
                                <option value="" disabled selected>Por favor selecciona</option>
                                <?php while ($row = $resultadoTipoVivienda->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id_tipo_vivienda']; ?>">
                                <?php echo htmlspecialchars($row['tipo_vivienda']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <button class="btnEnviar" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/scriptObtenerCiudades.js"></script>
    <script src="../js/scriptAlertas.js"></script>
    <script src="../js/scriptMenuHamburguesa.js"></script>
</body>
</html>
