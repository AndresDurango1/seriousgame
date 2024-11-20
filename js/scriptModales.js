//Obtener referencia a los elementos del DOM
const contenedorInicioSesion = document.getElementById('contenedorFormularioInicioSesion');

const btnInicioSesion = document.getElementById('btnIniciarSesion');
const btnRegistro = document.getElementById('btnRegistrar');

const cerrarInicio = document.getElementById ('iconoCerrarIS');

btnInicioSesion.addEventListener('click', function (){
    contenedorInicioSesion.style.display = "flex";
})
cerrarInicio.addEventListener('click', function(){
    contenedorInicioSesion.style.display = "none";
})
btnRegistro.addEventListener('click', function (){
    window.location.href = '../pages/formularioRegistroUsuario.php';
})
