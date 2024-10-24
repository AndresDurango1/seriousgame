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

                <button type="submit">Iniciar sesión</button>
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
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" required>
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
                <input type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" required>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <div class="contenedorSecciones">
        <section class="about-us" id="about-us">
            <h2>Conoce más</h2>
            <p>Un Avatar (humanoide, con poderes para convertirse en quark), que viaje por diferentes centros de datos y que durante ese recorrido vaya descubriendo mundos y superando ciertos retos para avanzar al siguiente. se pretende que el Avatar durante esos viajes vaya acompañado de su tripulación a bordo de su nave y en la interacción con su tripulación les cuente sus experiencias/aprendizajes y resuelva inquietudes.</p>
        </section>
        <section class="game-features" id="game-features">
            <h2>Mundos</h2>
            <div class="carousel">
                <div class="carousel-item active">Mundo 1 “Data Center”
                    <p>La nave aterriza en un centro de datos Tigo, el Avatar y su tripulación se prestan a dar un recorrido por el data center descubriendo los diferentes equipos, a decir; RACK, Servidores, Equipos de red, cableado, Piso falso, Escalerillas para cableado, etc. Así mismo, van encontrando que todos esos elementos permiten alojar los diferentes productos iniciales como; Collocation, hosting, Cross conexión, etc.</p>
                </div>

                <div class="carousel-item">Mundo 2 “IaaS”
                    <p>El Avatar con su tripulación (dentro de la nave) se adentran a una Máquina de cómputo o servidor, dentro del cual pueden visualizar los elementos que componen ese ordenador. Así como visualizan elementos físicos (Hardware) también visualizan elementos lógicos (Software).</p>
                </div>

                <div class="carousel-item">Mundo 3 “Servicios Cloud Tigo”
                    <p>Habiendo experimentado y superado el mundo anterior (IaaS), el Avatar se dispone a experimentar y contar como funciona el mundo “Servicios Cloud Tigo”.</p>
                </div>

                <div class="carousel-item">Mundo 4 “Servicios Cloud AWS”
                    <p>Así como vivió el mundo 3 “Servicios Cloud Tigo”, se debe preparar para un viaje a través de redes fijas (terrestres y submarinas) para llegar a un data center en Virginia y una vez adentro experimentar cómo funcionan algunos servicios iCloud AWS. También vivir la experiencia (un poco más rápida) en otros data center de AWS.</p>
                </div>

                <div class="carousel-item">Mundo 5 “Servicios Cloud Azure”
                    <p>Similar al anterior mundo, se debe preparar para un viaje a través de redes fijas (terrestres) para llegar a un data center en Arizona y una vez adentro experimentar cómo funcionan algunos servicios iCloud Azure.</p>
                </div>

                <div class="carousel-item">Mundo 6 “Ciber seguridad”
                    <p>En este mundo el Avatar vive una experiencia viajando a través de redes y equipos de seguridad, en esa experiencia es perseguido y atacado por otras naves que buscan alterar/dañar las diferentes redes y equipos por los cuales pasan. En esta experiencia el Avatar debe ser ayudado por otras naves que tienen nombres particulares.</p>
                </div>

                <div class="carousel-item">Mundo 7 “UcaaS”
                    <p>Esta es el mundo de la voz y la colaboración en el cual el Avatar con su tripulación viajan desde un dispositivo a otros por redes fijas y móviles viviendo experiencias terrestres (cableadas) y aéreas (Ondas).</p>
                </div>

                <div class="carousel-item">Mundo 8 “SDWAN”
                    <p>Este mundo será una nueva experiencia para el Avatar pues tendrá viajes en los cuales puede decidir por dos caminos que se le presentan, elegir uno de ellos dando a entender cuál es el más eficiente además de vivir una experiencia segura por esos caminos.</p>
                </div>
                <div class="carousel-navigation">
                <button class="carousel-button" id="prevButton">Anterior</button>
                <button class="carousel-button" id="nextButton">Siguiente</button>
        </section>
        <section class="player-handbook" id="player-handbook">
        </section>
    </div>
    <script src="../js/scriptBarraNavegacion.js"></script>
    <script src="../js/scriptModales.js"></script>
</body>
</html>