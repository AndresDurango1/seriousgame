function mostrarimgVistaPrevia(imagenSeleccionada = "default.png", idImagen = 87) {
    const imgVistaPrevia = document.getElementById("imgVistaPrevia");
    const inputIdImagenPerfil = document.getElementById("inputIdImagenPerfil");

    console.log("Imagen seleccionada:", imagenSeleccionada); // Console log para Verificar ruta de la imagen
    console.log("ID de la imagen:", idImagen); // Console log para Verificar id_imagen recibido

    if (imgVistaPrevia) {
        console.log("Elemento con id 'imgVistaPrevia' encontrado:", imgVistaPrevia);
        imgVistaPrevia.src = `../recursos/img/imgPerfil/${imagenSeleccionada}`;
    } else {
        console.error("Elemento con id 'imgVistaPrevia' no encontrado.");
    }
    if (inputIdImagenPerfil) {
        inputIdImagenPerfil.value = idImagen;
        console.log("inputIdImagenPerfil actualizado con idImagen:", idImagen);
    } else {
        console.error("Elemento con id 'inputIdImagenPerfil' no encontrado.");
    }
}
// Llama a la función con la imagen por defecto si no hay ninguna seleccionada
document.addEventListener("DOMContentLoaded", () => {
    const inputIdImagenPerfil = document.getElementById("inputIdImagenPerfil");
    if (inputIdImagenPerfil && !inputIdImagenPerfil.value) {
        inputIdImagenPerfil.value = "87"; // Valor por defecto
    }
    console.log("ID de la imagen (valor predeterminado):", inputIdImagenPerfil?.value);
    mostrarimgVistaPrevia();
    cargarImagenesPorCategoria();
});
function cargarImagenesPorCategoria() {
    const categoriaId = document.getElementById("inputCategoriaImagenPerfil").value;
    const contenedorImagenesCategoria = document.getElementById("contenedorImagenesCategoria");
    contenedorImagenesCategoria.innerHTML = "";
    if (categoriaId) {
        fetch(`../php/obtenerImagenes.php?categoria_id=${categoriaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(imagen => {
                        const imagenElement = document.createElement("img");
                        imagenElement.src = `../recursos/img/imgPerfil/${imagen.ruta_imagen}`;
                        imagenElement.classList.add("imagen-previa");
                        imagenElement.onclick = function() {
                            mostrarimgVistaPrevia(imagen.ruta_imagen, imagen.id_imagen);
                        };
                        contenedorImagenesCategoria.appendChild(imagenElement);
                    });
                } else {
                    contenedorImagenesCategoria.innerHTML = "No hay imágenes disponibles para esta categoría.";
                }
            })
            .catch(error => console.error('Error al cargar imágenes:', error));
    } else {
        const mensaje = document.createElement("p");
        mensaje.classList.add("mensaje-error");
        mensaje.innerText = "Por favor, selecciona una categoría para ver las imágenes disponibles.";
        contenedorImagenesCategoria.appendChild(mensaje);
    }
}

