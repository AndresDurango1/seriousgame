<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Document</title>
</head>
<body>
<div class="video-background">
    <video autoplay muted loop>
        <source src="../recursos/videos/intro.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>
    <div class="contenedorPrincipal">
        <nav class="barraNavegacion">
            <div class="contenedorLista">
                <ol class="opcionesNavegacion">
                    <img width="60" height="auto" src="../recursos/img/logo2Tigo.png" alt="" >
                    <li>Inicio</li>
                    <li>Mundos</li>
                    <li>Instrucciónes</li>
                    <li>Sobre nosotros</li>
                </ol>
            </div>
            <div class="contenedorBotones">
                <button class="btnLoging">Iniciar Sesión</button>
                
            </div>
        </nav>


        <section class="home">
            <h1 class="titulo">LAS AVENTURAS DE GO</h1>
            <p class="presentacion">
                Embárcate en una épica aventura con tu Avatar, un humanoide con el poder de transformarse en quark,
                 mientras explora vastos centros de datos y descubre mundos ocultos. Viaja junto a una tripulación leal a bordo de tu nave,
                enfrentando desafíos en cada mundo para avanzar. ...
            </p>
            <div class="contenedorBotonesHome">
                
                <button class="btnRegistrar">Registrarse </button>
            </div>
            <div class="contenedorMensajeScroll">
                <p class="mensajeScroll">Desliza para saber más</p>
            </div>
            <div class="contenedorScrollIcon">
                <img class="scrollIcon" src="../recursos/img/scrollIcon.png" alt="Icono Scroll">
            </div>
            </section>
        
    </div>
   
</div>
<div class="container" >
 </section>
        <div class="features-section">
        <div class="features-title">Mundos</div>
        <div class="features-grid">
            <div class="feature-item" onclick="showFeature('In-game Currency')">
                <div class="feature-icon">💰</div>
                <div class="feature-name">In-game Currency</div>
            </div>
            <div class="feature-item" onclick="showFeature('Boss Battles')">
                <div class="feature-icon">🔥</div>
                <div class="feature-name">Boss Battles</div>
            </div>
            <div class="feature-item" onclick="showFeature('Questing')">
                <div class="feature-icon">📜</div>
                <div class="feature-name">Questing</div>
            </div>
            <div class="feature-item" onclick="showFeature('Claim the Throne')">
                <div class="feature-icon">👑</div>
                <div class="feature-name">Claim the Throne</div>
            </div>
            <div class="feature-item" onclick="showFeature('Mystery Boxes')">
                <div class="feature-icon">🎁</div>
                <div class="feature-name">Mystery Boxes</div>
            </div>
        </div>
        <div class="feature-description" id="feature-description">
            Selecciona una característica para más detalles.
        </div>
    </div>

    <script>
        function showFeature(featureName) {
            const descriptionElement = document.getElementById('feature-description');
            descriptionElement.innerText = "Has seleccionado:" ${featureName} "Más detalles próximamente.";
        }
    </script>
</div>



   
</body>
</html>