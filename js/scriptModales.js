//Obtener referencia a los elementos del DOM
const contenedorInicioSesion = document.getElementById('contenedorFormularioInicioSesion');
const contenedorFormularioRegistro = document.getElementById('contenedorFormularioRegistro');

const btnInicioSesion = document.getElementById('btnIniciarSesion');
const btnRegistro = document.getElementById('btnRegistrar');

const cerrarInicio = document.getElementById ('iconoCerrarIS');
const cerrarRegistro = document.getElementById ('iconoCerrarR');

btnInicioSesion.addEventListener('click', function (){
    contenedorInicioSesion.style.display = "flex";
})
cerrarInicio.addEventListener('click', function(){
    contenedorInicioSesion.style.display = "none";
})
btnRegistro.addEventListener('click', function (){
    contenedorFormularioRegistro.style.display = "flex";
})
cerrarRegistro.addEventListener('click', function(){
    contenedorFormularioRegistro.style.display = "none";
})