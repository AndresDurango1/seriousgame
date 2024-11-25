//Obtener referencia a los elementos del DOM
const contenedorInicioSesion = document.getElementById('contenedorFormularioInicioSesion');
const btnInicioSesion = document.getElementById('btnIniciarSesion');
const btnResgistro = document.getElementById('btnRegistrar');
const cerrarModalIP = document.getElementById ('iconoCerrarIP');
const cerrarModalRC = document.getElementById ('iconoCerrarRC');

//Funcione call back para mostrar y cerrar el modal del index
if(btnInicioSesion){
    btnInicioSesion.addEventListener('click', function (){
        contenedorInicioSesion.style.display = "flex";
    })
}
//Funcion para redirigir al formulario de registro
if(btnResgistro){
    btnResgistro.addEventListener('click', function (){
        window.location.href = "../pages/formularioRegistroUsuario.php";
    })
}
if(cerrarModalIP){
    cerrarModalIP.addEventListener('click', function(){
        contenedorInicioSesion.style.display = "none";
    })
}
// Cerrar el modal si se hace clic fuera de él
document.addEventListener('click', function (event) {
    if (!contenedorInicioSesion.contains(event.target) && event.target !== btnInicioSesion) {
        contenedorInicioSesion.style.display = "none";
    }
});
//Funcion para volver al index desde el formulario de recuperar contraseña
if(cerrarModalRC){
    cerrarModalRC.addEventListener('click', function(){
        window.location.href = "../pages/index.php";
    });
}