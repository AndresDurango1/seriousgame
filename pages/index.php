
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
        <nav class="barraNavegacion fixed-top">
            <div class="contenedorLista">
                <ol class="opcionesNavegacion">
                <li><a href="#home" class="nav-link">Inicio</a></li>
                <li><a href="#acerca-de-nosotros" class="nav-link">Acerca de Nosotros</a></li>
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
                <button class="btnLoging" id="btnIniciarSesion">Iniciar Sesión</button>
                <button class="btnRegistrar" id="btnRegistrar">Registrarse</button>
            </div>
            <div class="contenedorScroll">
                <div class="contenedorScrollIcon">
                    <img class="scrollIcon" src="../recursos/img/imgIndexPage/iconoScroll.png" alt="Icono Scroll">
                </div>
                <p class="mensajeScroll">Desliza para saber más</p>
            </div>
        </section>
        <!-- MODAL FORMULARIO INICIO DE SESION -->
        <div class="contenedorFormularioInicioSesion" id="contenedorFormularioInicioSesion">
            <div class="contenedorIconoCerrarIS">
                <i class="far fa-window-close" style="color: #000000;" id="iconoCerrarIS"></i>
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
        <div class="contenedorSecciones">
            <section id="acerca-de-nosotros" class="info-section">
                <h1 class="titulo">Acerca de Nosotros</h1>
                <p class="descripcion">Un Avatar (humanoide, con poderes para convertirse en quark), que viaje por diferentes centros de datos y que durante ese recorrido vaya descubriendo mundos y superando ciertos retos para avanzar al siguiente. se pretende que el Avatar durante esos viajes vaya acompañado de su tripulación a bordo de su nave y en la interacción con su tripulación les cuente sus experiencias/aprendizajes y resuelva inquietudes.</p>
            </section>
            <section id="game-features" class="game-features">
                <h1 class="titulo">Características del Juego</h1>
                <p class="descripcion">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi culpa eius fuga asperiores, placeat et similique veniam voluptate cumque unde delectus obcaecati praesentium repellat nulla nesciunt, sint quos minima ut. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Esse eos iure, animi porro maiores blanditiis ullam sapiente omnis in soluta atque ratione fugiat, possimus, facilis quod natus optio earum repellat. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Alias dolorem eum quod officiis cum placeat minus quibusdam, aut enim quidem unde totam reprehenderit aperiam repudiandae hic incidunt dolor molestias perferendis? Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus minima repudiandae voluptas debitis, consequatur delectus hic ex ea aut nihil labore fuga sit eum expedita maxime soluta eveniet sint magnam? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eligendi, neque! Vel odio aliquam voluptatum non facere doloribus hic dignissimos maiores cumque ducimus, itaque accusamus deleniti odit quas asperiores ipsam harum!</p>
                <div class="contenedorImagenesGameFeatures">
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo1">
                        <img src="../recursos/img/imgIndexPage/banderinMundo1.png" alt="" class="imagenMundo1" id="imagenMundo1" onclick="mostrarTexto(1)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo2">
                        <img src="../recursos/img/imgIndexPage/banderinMundo2.png" alt="" class="imagenMundo2" id="imagenMundo2" onclick="mostrarTexto(2)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo3">
                        <img src="../recursos/img/imgIndexPage/banderinMundo3.png" alt="" class="imagenMundo3" id="imagenMundo3" onclick="mostrarTexto(3)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo4">
                        <img src="../recursos/img/imgIndexPage/banderinMundo4.png" alt="" class="imagenMundo4" id="imagenMundo4" onclick="mostrarTexto(4)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo5">
                        <img src="../recursos/img/imgIndexPage/banderinMundo5.png" alt="" class="imagenMundo5" id="imagenMundo5" onclick="mostrarTexto(5)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo6">
                        <img src="../recursos/img/imgIndexPage/banderinMundo6.png" alt="" class="imagenMundo6" id="imagenMundo6" onclick="mostrarTexto(6)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo7">
                        <img src="../recursos/img/imgIndexPage/banderinMundo7.png" alt="" class="imagenMundo7" id="imagenMundo7" onclick="mostrarTexto(7)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo8">
                        <img src="../recursos/img/imgIndexPage/banderinMundo8.png" alt="" class="imagenMundo8" id="imagenMundo8" onclick="mostrarTexto(8)">
                    </div>
                    <div class="contenedorImagenMundo" id="contenedorImagenMundo9">
                        <img src="../recursos/img/imgIndexPage/banderinMundo9.png" alt="" class="imagenMundo9" id="imagenMundo9" onclick="mostrarTexto(9)">
                    </div>
                </div>
                <div class="contenedorInfoMundo" id="contenedorInfoMundo">
                    <div class="contenedorImagenMundo">
                        <img class="imagenMundo" id="imagenMundo" src="" alt="">
                    </div>
                    <p class="infoMundo" id="infoMundo"></p>
                </div>
            </section>
            <section id="player-handbook" class="manualDelJugador">
                <h1 class="titulo">Manual Del Jugador</h1>
                <p class="descripcion">Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi culpa eius fuga asperiores, placeat et similique veniam voluptate cumque unde delectus obcaecati praesentium repellat nulla nesciunt, sint quos minima ut. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Esse eos iure, animi porro maiores blanditiis ullam sapiente omnis in soluta atque ratione fugiat, possimus, facilis quod natus optio earum repellat. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Alias dolorem eum quod officiis cum placeat minus quibusdam, aut enim quidem unde totam reprehenderit aperiam repudiandae hic incidunt dolor molestias perferendis? Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus minima repudiandae voluptas debitis, consequatur delectus hic ex ea aut nihil labore fuga sit eum expedita maxime soluta eveniet sint magnam? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eligendi, neque! Vel odio aliquam voluptatum non facere doloribus hic dignissimos maiores cumque ducimus, itaque accusamus deleniti odit quas asperiores ipsam harum!</p>
                <div class="contenedorImagenesTutorial">
                    <div class="contenedorImagenControlesTeclado">        
                        <img class="imagenControlesTeclado" src="../recursos/img/imgIndexPage/controlesTeclado.png" alt="">
                    </div>
                    <div class="contenedorImagenBotonesPrincipales">                
                        <img class="imagenBotonesPrincipales" src="../recursos/img/imgIndexPage/botonesPrincipales.png" alt="">
                    </div>
                </div>
             </section>
        </div>
    </div>
    <script src="../js/scriptBarraNavegacion.js"></script>
    <script src="../js/scriptModales.js"></script>
    <script src="../js/scriptInfoNiveles.js"></script>
</body>
</html>