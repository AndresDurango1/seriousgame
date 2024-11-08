<?php
session_start();
include_once '../php/conexion.php';
$conexion = conectar();
//Consulta a la base de datos para las categorias de las imagenes
$stmtCategorias = $conexion->prepare("SELECT DISTINCT id_categoria, categoria FROM categoria_imagenes ORDER BY id_categoria ASC");
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
    <link rel="stylesheet" href="../css/estilosFormularioRegistro.css">
    <title>Document</title>
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorLista">
            <ol class="opcionesNavegacion">
                <li><a href="#home" class="nav-link">Inicio</a></li>
                <li><a href="#about-us" class="nav-link">Acerca de Nosotros</a></li>
            </ol>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorLista">
            <ol class="opcionesNavegacion">
                <li><a href="#game-features" class="nav-link">Características del Juego</a></li>
                <li><a href="#player-handbook" class="nav-link">Manual del Jugador</a></li>
            </ol>
        </div>
    </nav>
    <div class="contenedorPrincipal">
        <div class="contenedorFormularioRegistro" id="contenedorFormularioRegistro">
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <h1 class="tituloFormularioRegistrarse">Regístrate</h1>
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
                        <input class="input-item" type="hidden" name="inputIdImagenPerfil" id="inputIdImagenPerfil">
                        <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                        <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Número de Identificación" required>
                        <label class="lbl-item" for="lblNombre">Nombre</label>
                        <input class="input-item" type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" required>
                        <label class="lbl-item" for="lblApellido">Apellido</label>
                        <input class="input-item" type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" required>
                    </div>
                    <div class="contenedorPage2">
                        <label class="lbl-item" for="lblUsuario">Usuario</label>
                        <input class="input-item" type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" required>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                            <label for="lblRol">Rol</label>
                            <select name="inputRol" id="inputRol">
                                <option>Selecciona un Rol</option>
                                <option value="0">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                        <?php endif; ?>
                        <label class="lbl-item" for="lblCorreo">Correo</label>
                        <input class="input-item" type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" required>
                        <label class="lbl-item" for="lblContrasena">Contraseña</label>
                        <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" required>

                    </div>
                </div>
                <button class="btnEnviar" type="submit">Enviar</button>
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