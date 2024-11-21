document.addEventListener('DOMContentLoaded', function () {
    const imagenesMundo = [
        document.getElementById("imagenMundo1"),
        document.getElementById("imagenMundo2"),
        document.getElementById("imagenMundo3"),
        document.getElementById("imagenMundo4"),
        document.getElementById("imagenMundo5"),
        document.getElementById("imagenMundo6"),
        document.getElementById("imagenMundo7"),
        document.getElementById("imagenMundo8"),
        document.getElementById("imagenMundo9")
    ];
    
    const contenedorInfoMundo = document.getElementById("contenedorInfoMundo");
    const parrafo = document.getElementById('infoMundo');
    const imagen  = document.getElementById('imagenMundo')

    function mostrarTexto(index) {
        const textos = [
            "¡Bienvenidos al Data Center! Aquí, nuestra nave aterriza en un moderno centro de datos de Tigo. En este punto crucial de la misión, el Avatar y su tripulación se encuentran con un personaje esencial que les proporciona importantes indicaciones de seguridad. Este guía les ayuda a entender y navegar de manera segura a través de los equipos y sistemas críticos del centro de datos.",

            "El Avatar y su tripulación se embarcan en un fascinante recorrido, descubriendo equipos esenciales como racks, servidores, equipos de red, cableado, piso falso y escalerillas para cableado. Durante su aventura, aprenden cómo estos componentes son fundamentales para alojar servicios vitales como collocation, hosting y conexiones cruzadas.",

            "En el Mundo de IaaS, el Avatar y su tripulación se adentran en las entrañas de una máquina de cómputo o servidor. Dentro de esta poderosa unidad, exploran tanto el hardware (componentes físicos) como el software (componentes lógicos) que juntos dan vida a la infraestructura como servicio (IaaS).",

            "Tras dominar el mundo de IaaS, el Avatar se aventura en el dinámico Mundo de los Servicios Cloud Tigo. Aquí, exploran cómo funcionan estos servicios en la nube, ofreciendo flexibilidad y potencia para diversos usos.",

            "Nuestro viaje continúa con un emocionante salto a través de redes fijas y submarinas hasta un centro de datos de AWS en Virginia. En este mundo, el Avatar experimenta de primera mano los servicios en la nube de AWS, disfrutando de una experiencia rápida y eficiente que también incluye visitas a otros centros de datos de AWS.",

            "Al igual que en el Mundo 5, el Avatar y su tripulación se preparan para un viaje por redes fijas hasta un centro de datos de Azure en Arizona. Aquí, descubren el funcionamiento de los servicios en la nube de Azure, explorando cómo estos servicios facilitan una gran variedad de aplicaciones.",

            "En este desafiante mundo, el Avatar se embarca en una misión a través de redes y equipos de seguridad. Durante su viaje, enfrentan amenazas y ataques de otras naves que intentan comprometer la infraestructura. Con la ayuda de aliados con nombres únicos, el Avatar debe proteger las redes y equipos vitales.",

            "Bienvenidos al Mundo de la Comunicación y la Colaboración. Aquí, el Avatar y su tripulación viajan desde un dispositivo a otro a través de redes fijas y móviles. Experimentan comunicaciones terrestres (cableadas) y aéreas (ondas), explorando cómo la voz y la colaboración se integran en nuestro mundo moderno. ",

            "Este nuevo mundo presenta una experiencia única para el Avatar. Deben elegir entre dos caminos, decidiendo cuál es el más eficiente mientras viven una experiencia segura por estos trayectos. La toma de decisiones y la seguridad son clave en este mundo fascinante"
        ];
        const imagenesSrc = [
            "../recursos/img/imgIndexPage/Mundo1.png",
            "../recursos/img/imgIndexPage/Mundo2.png",
            "../recursos/img/imgIndexPage/Mundo3.png",
            "../recursos/img/imgIndexPage/Mundo4.png",
            "../recursos/img/imgIndexPage/Mundo5.png",
            "../recursos/img/imgIndexPage/Mundo6.png",
            "../recursos/img/imgIndexPage/Mundo7.png",
            "../recursos/img/imgIndexPage/Mundo8.png",
            "../recursos/img/imgIndexPage/Mundo9.png",
        ]
        parrafo.textContent = textos[index - 1] || "Información no disponible";
        parrafo.style.display = "flex"
        imagen.src = imagenesSrc[index - 1];
        imagen.style.display = "flex";
        contenedorInfoMundo.style.display = "flex";
    }

    imagenesMundo.forEach((img, index) => {
        if (img) {
            img.addEventListener('click', () => mostrarTexto(index + 1));
        }
    });
});