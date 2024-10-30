<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/indexStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedorPrincipal">
        <video autoplay muted loop class="video-background">
            <source src="../recursos/videos/intro_2.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
        <nav class="barraNavegacion">
            <div class="contenedorLista">
                <ol class="opcionesNavegacion">
                <li><a href="#home" class="nav-link">Inicio</a></li>
                <li><a href="#about-us" class="nav-link">Acerca de Nosotros</a></li>
                <li><a href="#game-features" class="nav-link">Características del Juego</a></li>
                <li><a href="#player-handbook" class="nav-link">Manual del Jugador</a></li>
                </ol>
            </div>
        </nav>
        <section class="home" id="home">
            <h1 class="titulo">LAS AVENTURAS DE GO</h1>
            <p class="presentacion">
                Embárcate en una épica aventura con tu Avatar, un humanoide con el poder de transformarse en quark, mientras explora vastos centros de datos y descubre mundos ocultos. Viaja junto a una tripulación leal a bordo de tu nave, enfrentando desafíos en cada mundo para avanzar.
            </p>
            <div class="contenedorBotonesHome">
                <button class="btnLoging" id="btnIniciarSesion" onclick="">Iniciar Sesión</button>
                <button class="btnRegistrar" id="btnRegistrar">Registrarse</button>
            </div>
            <div class="contenedorScrollIcon">
                <img class="scrollIcon" src="../recursos/img/iconoScroll.png" alt="Icono Scroll">
            </div>
            <div class="contenedorMensajeScroll">
                <p class="mensajeScroll">Desliza para saber más</p>
            </div>
        </section>
        <!-- MODAL FORMULARIO INICIO DE SESION -->
        <div class="contenedorFormularioInicioSesion" id="contenedorFormularioInicioSesion">
            <div class="contenedorIconoCerrarIS">
                <i class="fal fa-window-close" style="color: #000000;" id="iconoCerrarIS"></i>
            </div>
            <h1 class="tituloFormularioInicioSesion">Inicio de Sesión</h1>
            <form action="../php/login.php" method="POST" class="fomularioInicioSesion">
                <label for="inputUsuario">Usuario</label>
                <input type="text" name="inputUsuario" id="inputUsuario" required>

                <label for="inputContrasena">Contraseña</label>
                <input type="password" name="inputContrasena" id="inputContrasena" required>

                <button type="submit" href="administrador.php">Iniciar sesión</button>
            </form>
            <p>
                <a href="formularioRecuperarContrasena.php">¿Olvidaste tu contraseña?</a>
            </p>
        </div>
        <!-- MODAL FORMULARIO REGISTRO -->
        <div class="contenedorFormularioRegistro" id="contenedorFormularioRegistro">
            <div class="contenedorIconoCerrarR">
                    <i class="fal fa-window-close" style="color: #000000;" id="iconoCerrarR"></i>
            </div>
            <h1 class="tituloFormularioRegistrarse">Registrate</h1>
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <label for="lblIdentificacion">Identificación</label>
                <input type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Número de Identificación" required>
                <label for="lblNombre">Nombre</label>
                <input type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" required>
                <label for="lblApellido">Apellido</label>
                <input type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" required>
                <label for="lblUsuario">Usuario</label>
                <input type="text" name="inputUsuarioR" id="inputUsuarioR" placeholder="Ingresa tu Usuario" required>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                <label for="lblRol">Rol</label>
                <select name="inputRol" id="inputRol">
                    <option>Selecciona un Rol</option>
                    <option value="0">Usuario</option>
                    <option value="1">Administrador</option>                
                </select>
                <?php endif; ?>
                <label for="lblCorreo">Correo</label>
                <input type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" required>
                <label for="lblContrasena">Contraseña</label>
                <input type="password" name="inputContrasenaR" id="inputContrasenaR" placeholder="Ingresa tu Contraseña" required>
                <button type="submit" >Enviar</button>
            </form>
        </div>
    </div>
        <div class="contenedorSecciones">
            <section id="acerca-de_nosotros" class="info-section">
                <h2 class="titulo">Acerca de Nosotros</h2>
                <p>Un Avatar (humanoide, con poderes para convertirse en quark), que viaje por diferentes centros de datos y que durante ese recorrido vaya descubriendo mundos y superando ciertos retos para avanzar al siguiente. se pretende que el Avatar durante esos viajes vaya acompañado de su tripulación a bordo de su nave y en la interacción con su tripulación les cuente sus experiencias/aprendizajes y resuelva inquietudes.</p>
            </section>
            <section class="game-features">
                <div class="contenedorInfoMundo" id="contenedorInfoMundo">
                    <p class="infoMundo" id="infoMundo"></p>
                </div>
                <div class="contenedorImagenesGameFeatures">
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo1">
                        <img src="../recursos/img/Mundo1.png" alt="" class="imagenMundo1" id="imagenMundo1" onclick="mostrarTexto(1)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo2">
                        <img src="../recursos/img/Mundo2.png" alt="" class="imagenMundo2" id="imagenMundo2" onclick="mostrarTexto(2)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo3">
                        <img src="../recursos/img/Mundo3.png" alt="" class="imagenMundo3" id="imagenMundo3" onclick="mostrarTexto(3)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo4">
                        <img src="../recursos/img/Mundo4.png" alt="" class="imagenMundo4" id="imagenMundo4" onclick="mostrarTexto(4)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo5">
                        <img src="../recursos/img/Mundo5.png" alt="" class="imagenMundo5" id="imagenMundo5" onclick="mostrarTexto(5)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo6">
                        <img src="../recursos/img/Mundo6.png" alt="" class="imagenMundo6" id="imagenMundo6" onclick="mostrarTexto(6)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo7">
                        <img src="../recursos/img/Mundo7.png" alt="" class="imagenMundo7" id="imagenMundo7" onclick="mostrarTexto(7)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo8">
                        <img src="../recursos/img/Mundo8.png" alt="" class="imagenMundo8" id="imagenMundo8" onclick="mostrarTexto(8)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo9">
                        <img src="../recursos/img/Mundo9.png" alt="" class="imagenMundo9" id="imagenMundo9" onclick="mostrarTexto(9)">
                    </div>
                </div>
            </section>
            <section class="about-us" id="about-us">
            </section>
            <section class="game-features" id="game-features">
            </section>
            <section class="player-handbook" id="player-handbook">
            </section>
        </div>
        
    <script src="../js/scriptBarraNavegacion.js"></script>
    <script src="../js/scriptModales.js"></script>
    <script src="../js/scriptInfoNiveles.js"></script>
</body>
</html>