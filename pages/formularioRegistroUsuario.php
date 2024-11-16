<?php
session_start();
$estaLogueado = isset($_SESSION['id_usuario']);
include_once '../php/conexion.php';
$conexion = conectar();
if ($estaLogueado) { $id_usuario = $_SESSION['id_usuario']; 
    $rol = $_SESSION['rol']; $miPerfilUrl = ($rol == 1) ? '../pages/administrador.php' : '../pages/usuario.php'; 
    // Consulta a la base de datos para traer la información del usuario 
    $stmt1 = $conexion->prepare("SELECT identificacion, nombre, apellido, correo, contrasena, id_imagen FROM usuarios WHERE id_usuario = ?"); 
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
    <link rel="stylesheet" href="../css/estilosFormularioRegistro.css">
    <title>Document</title>
</head>
<body>
    <nav class="barraNavegacion">
        <div class="contenedorBotonesRedireccion">
            <button class="btnRedireccion" onclick="window.location.href='../pages/index.php'">HOME</button>
            <button class="btnRedireccion" onclick="window.location.href='<?php echo $miPerfilUrl; ?>'">Mi perfil</button>
        </div>
        <div class="contenedorTitulo">
            <p class="titulo">Las Aventuras de Go</p>
        </div>
        <div class="contenedorLista">
            <ol class="opcionesNavegacion">
                <li><a href="../pages/index.php#game-features" class="nav-link">Características del Juego</a></li>
                <li><a href="../pages/index.php#player-handbook" class="nav-link">Manual del Jugador</a></li>
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
                    </div>
                    <div class="contenedorPage2">
                        <label class="lbl-item" for="lblIdentificacion">Identificación</label>
                        <input class="input-item" type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Número de Identificación" required>
                        <label class="lbl-item" for="lblNombre">Nombre</label>
                        <input class="input-item" type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" required>
                        <label class="lbl-item" for="lblApellido">Apellido</label>
                        <input class="input-item" type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" required>
                        <label class="lbl-item" for="lblUsuario">Usuario</label>
                        <input class="input-item" type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" required>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                            <label class="lbl-item" for="lblRol">Rol</label>
                            <select class="input-item" name="inputRol" id="inputRol">
                                <option>Selecciona un Rol</option>
                                <option value="0">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                        <?php endif; ?>
                        <label class="lbl-item" for="lblCorreo">Correo</label>
                        <input class="input-item" type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" required>
                        <label class="lbl-item" for="lblContrasena">Contraseña</label>
                        <input class="input-item" type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" required>
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