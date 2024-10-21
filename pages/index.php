<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <header>
       
        <nav>
            <ul>
               <img width="60" height="auto" src="../recursos/img/logo2Tigo.png" alt="" >
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#carrusel">Mundos</a></li>
                <li><a href="#conocer-mas">Conocer más</a></li>
                <li><a href="#Instrucciónes">Instrucciónes</a></li>
            </ul>
        </nav>
    </header>

    <section id="inicio" class="video-background">
        <video autoplay muted loop>
            <source src="../recursos/videos/intro.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
        <div class="overlay">
            <h2 class="TITULO" >LAS AVENTURAS DE GO</h2>
               <h5 class="textoinformativo" >Embárcate en una épica aventura con tu Avatar, un humanoide con el poder de transformarse en quark,
                 mientras explora vastos centros de datos y descubre mundos ocultos. Viaja junto a una tripulación leal a bordo de tu nave,
                  enfrentando desafíos en cada mundo para avanzar.</h5>
            <button id="registerButton">Iniciar Sesión</button>
            <button id="learnMoreButton">Registrarse</button>
        </div>
    </section>

    <section id="conocer-mas" class="info-section">
        <h2>Conoce más</h2>
        <p>Un Avatar (humanoide, con poderes para convertirse en quark), que viaje por diferentes centros de datos y que durante ese recorrido vaya descubriendo mundos y superando ciertos retos para avanzar al siguiente. se pretende que el Avatar durante esos viajes vaya acompañado de su tripulación a bordo de su nave y en la interacción con su tripulación les cuente sus experiencias/aprendizajes y resuelva inquietudes.</p>
    </section>

    <section id="carrusel" class="carousel-section">
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
    </div>
    </div>

   
</section>


    <section id="Instrucciónes">
      <h2>Instrucciónes</h2>
      <p></p>
    </section>

    <script src="script.js"></script>
</body>
</html>
