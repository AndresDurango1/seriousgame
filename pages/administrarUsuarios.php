<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 1) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            
        </div>
    </div>
</body>
</html>