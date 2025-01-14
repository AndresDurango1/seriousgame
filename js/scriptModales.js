//Obtener referencia a los elementos del DOM del index.php
const contenedorInicioSesion = document.getElementById('contenedorFormularioInicioSesion');
const contenedorRegistro = document.getElementById('contenedorFormularioRegistro');
const btnInicioSesion = document.getElementById('btnIniciarSesion');
const btnResgistro = document.getElementById('btnRegistrar');
const cerrarModalIS = document.getElementById ('iconoCerrarIS');
const cerrarModalR = document.getElementById ('iconoCerrarR');
const cerrarModalRC = document.getElementById ('iconoCerrarRC');

const iconoHome = document.getElementById("iconoHome");
const iconoUsers = document.getElementById("iconoUsers");
const iconoPuzzle = document.getElementById("iconoPuzzle");
const iconoGamepad = document.getElementById("iconoGamepad");
const inicioSesion = document.getElementById("inicioSesion");

//Funcione call back para mostrar el modal del index
if(btnInicioSesion){
    btnInicioSesion.addEventListener('click', function (){
        if (window.getComputedStyle(contenedorInicioSesion).display == 'none') {
            contenedorInicioSesion.style.display = 'flex';
        }
    })
}
if(btnResgistro){
    btnResgistro.addEventListener('click', function (){
        if (window.getComputedStyle(contenedorRegistro).display == 'none') {
            contenedorRegistro.style.display = 'flex';
        }
    })
}
if(inicioSesion){
    inicioSesion.addEventListener('click',function(){
        console.log("clic en el boton")
        if (contenedorInicioSesion.display === "none") {
            contenedorInicioSesion.style.display = "flex";
        }        
    });
}
//Funcion para redirigir al formulario de registro
if(btnResgistro){
    btnResgistro.addEventListener('click', function (){
        //window.location.href = "../pages/formularioRegistroUsuario.php";
        console.log("clic en el boton registro");
        if (contenedorRegistro.display === "none") {
            contenedorRegistro.style.display = "flex";
        }        
    })
}
//Funcion para cerrar los modales
if(cerrarModalIS){
    cerrarModalIS.addEventListener('click', function(){
        contenedorInicioSesion.style.display = "none";
    })
}
if(cerrarModalR){
    cerrarModalR.addEventListener('click', function(){
        contenedorRegistro.style.display = "none";
    })
}
// Cerrar el modal de inicio de sesion si se hace clic fuera de él
document.addEventListener('click', function (event) {
    if (!contenedorInicioSesion.contains(event.target) && event.target !== btnInicioSesion) {
        contenedorInicioSesion.style.display = "none";
    }
});
// Cerrar el modal de contenedor de registro si se hace clic fuera de él
document.addEventListener('click', function (event) {
    if (!contenedorRegistro.contains(event.target) && event.target !== btnResgistro) {
        contenedorRegistro.style.display = "none";
    }
});
//Funcion para volver al index desde el formulario de recuperar contraseña
if(cerrarModalRC){
    cerrarModalRC.addEventListener('click', function(){
        window.location.href = "../pages/index.php";
    });
}
//Funcion para volver al home con el icono
if(iconoHome){
    iconoHome.addEventListener('click',function(){
        window.location.href = "../pages/index.php#home";
    });
}
//Funcion para volver al users con el icono
if(iconoUsers){
    iconoUsers.addEventListener('click',function(){
        window.location.href = "../pages/index.php#acerca-de-nosotros";
    });
}
//Funcion para volver al Puzzle con el icono
if(iconoPuzzle){
    iconoPuzzle.addEventListener('click',function(){
        window.location.href = "../pages/index.php#game-features";
    });
}
//Funcion para volver al Gamepad con el icono
if(iconoGamepad){
    iconoGamepad.addEventListener('click',function(){
        window.location.href = "../pages/index.php#player-handbook";
    });
}
//Funcion para redirigir al inicio de sesion
//Funcione call back para mostrar el modal del index
if(inicioSesion){
    inicioSesion.addEventListener('click',function(){
        contenedorInicioSesion.style.display = "flex";
    });
}