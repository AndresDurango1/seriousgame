<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilosInformacionUsuario.css">
    <title>Document</title>
</head>
<body>
<nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">Inicio</button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/formularioCaracterizacion.php'">Formulario Caracterización</button>
            <button class="btnRedireccion" onclick="window.location.href='../pages/estadisticas.php'">Ver Estadísticas</button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorInfoUsuario">
            <div class="contenedorIconoUsuario">
                <img class="iconoUsuario" src="../recursos/img/imgPerfil/<?php echo $ruta_imagen; ?>" alt="iconoUsuario">
            </div>
            <div class="contenedorNombreUsuario">
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
    <main>
    <aside class="sidebar">
            <h2>Mi perfil</h2>
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <label for="lblIdentificacion">Identificación</label>
                <input type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="" required>
                <label for="lblNombre">Nombre</label>
                <input type="text" name="inputNombre" id="inputNombre" placeholder="" required>
                <label for="lblApellido">Apellido</label>
                <input type="text" name="inputApellido" id="inputApellido" placeholder="" required>
                <label for="lblCorreo">Correo</label>
                <input type="text" name="inputCorreo" id="inputCorreo" placeholder="" required>
                <label for="lblCelular">Celular</label>
                <input type="text" name="inputCelular" id="inputCelular" placeholder="" required>
            </form>
        </aside>

        
        <!-- Contenedor vacío 1 -->
        <div class="contenedor1"></div>

        <!-- Contenedor vacío 2 -->
        <div class="contenedor2"></div>
</main>
</body>
</html>