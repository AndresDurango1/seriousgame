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
            "Hola perras"
        ];

        parrafo.textContent = textos[index - 1] || "Información no disponible";
        contenedorInfoMundo.style.display = "flex";
    }

    imagenesMundo.forEach((img, index) => {
        if (img) {
            img.addEventListener('click', () => mostrarTexto(index + 1));
        }
    });
});