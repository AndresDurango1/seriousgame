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
            "La nave aterriza en un centro de datos Tigo...",
            "El Avatar con su tripulación se adentran a una Máquina de cómputo o servidor...",
            "Habiendo experimentado y superado el mundo anterior...",
            "Así como vivió el mundo 3, se prepara para un viaje...",
            "Similar al anterior mundo, se debe preparar para un viaje...",
            "En este mundo el Avatar vive una experiencia viajando a través de redes...",
            "Esta es el mundo de la voz y la colaboración...",
            "Este mundo será una nueva experiencia para el Avatar...",
            "Hola "
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
        imagen.src = imagenesSrc[index - 1] || "";
        contenedorInfoMundo.style.display = "flex";
    }

    imagenesMundo.forEach((img, index) => {
        if (img) {
            img.addEventListener('click', () => mostrarTexto(index + 1));
        }
    });
});