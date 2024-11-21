const params = new URLSearchParams(window.location.search);
//Alertas index.php contraseña o usuario incorrecto en el login
if(params.has('contrasena-incorrecta') || params.has('usuario-no-encontrado')){
    let title, text, icon, confirmButtonText;
    switch (true) {
        case params.has('contrasena-incorrecta'):
            title = '!Error!';
            text = 'La contraseña ingresada es incorrecta';
            icon ='error';
            confirmButtonText = 'Aceptar';
            break;
        case params.has('usuario-no-encontrado'):
            title = '!Error!';
            text = 'El usuario ingresado no existe o es incorrecto';
            icon ='error';
            confirmButtonText = 'Aceptar';
            break;
    }
    mostrarAlertasLogin(title, text, icon, confirmButtonText);
}
//Alertas para la pagina de Cambio de contraseña
if(params.has('status-success') || params.has('status-error')){
    let title, text, icon, confirmButtonText;
    switch (true) {
        case params.has('status-success'):
            title = '!Atención!';
            text = 'El enlace para restablecer la contraseña ha sido enviado a tu correo electrónico.';
            icon ='success';
            confirmButtonText = 'Aceptar';
            break;
        case params.has('status-error'):
            title = '!Atención!';
            text = 'El enlace para restablecer la contraseña no pudo ser enviado a tu correo electrónico. Por favor intenta nuevamente';
            icon ='success';
            confirmButtonText = 'Aceptar';
            break;
    }
    mostrarAlertaRecuperarContrasena(title, text, icon, confirmButtonText);
}
//Alertas para la pagina de Usuario: Alerta diligenciamiento formulario de caracterizacion por primera vez
if(params.has('caracterizacion')){
    let title, text, icon, confirmButtonText, cancelButtonText;
    switch (true) {
        case params.has('caracterizacion'):
            title = '!Atención!';
            text = 'Por favor completa la información de caracterización demográfica.';
            icon ='warning';
            confirmButtonText = 'Completar ahora';
            cancelButtonText = 'Completar mas tarde';
            break;
    }
    mostrarAlertaCaracterizacion(title, text, icon, confirmButtonText, cancelButtonText);
};
//Alertas para la pagina de Usuario: Seccion Actualizacion de Perfil
if (params.has('actualizado') || params.has('contrasenaIsDifferent')) {
    let title, text, icon, confirmButtonText;
    switch (true) {
        case params.has('actualizado'):
            title = '¡Éxito!';
            text = 'Los cambios se han guardado correctamente.';
            icon = 'success';
            confirmButtonText = 'Aceptar';
            break;

        case params.has('contrasenaIsDifferent'):
            title = '¡Error!';
            text = 'Las contraseñas no coinciden. Por favor, intenta de nuevo.';
            icon = 'error';
            confirmButtonText = 'Aceptar';
            break;
    }
    mostrarAlertasUsuario(title, text, icon, confirmButtonText);
};
//Alertas para la pagina de Formulario Caracterización
if (params.has('fc-actualizado') || params.has('fc-insertado')|| params.has('fc-no-actualizado') || params.has('fc-no-insertado')) {
    let title, text, icon, confirmButtonText;
    switch (true) {
        case params.has('fc-actualizado'):
            title = '!Éxito!';
            text = 'La información del formulario de caracterización demográfica se ha actualizado correctamente.';
            icon ='success';
            confirmButtonText = 'Aceptar';
            break;
        case params.has('fc-insertado'):
            title = '!Éxito!';
            text = 'La información del formulario de caracterización demográfica se ha guardado correctamente.';
            icon ='success';
            confirmButtonText = 'Aceptar';
            break;
        case params.has('fc-no-actualizado'):
            title = '!Error!';
            text = 'La información del formulario de caracterización demográfica no se ha podido actualizar. Por favor, intenta de nuevo mas tarde.';
            icon ='error';
            confirmButtonText = 'Aceptar';
            break;
        case params.has('fc-no-insertado'):
            title = '!Error!';
            text = 'La información del formulario de caracterización demográfica no se ha podido guardar. Por favor, intenta de nuevo mas tarde.';
            icon ='error';
            confirmButtonText = 'Aceptar';
            break;
    }
    mostrarAlertasFormularioCaracterizacion(title, text, icon, confirmButtonText);
};
//Alerta para otros errores del formulario de caracterizacion
if (params.has('fc-error') && params.get('fc-error') === 'true' && params.has('errores')) {
    const errores = decodeURIComponent(params.get('errores')).split(',');
    const mensajeErrores = errores.join("\n");  
    Swal.fire({
        title: '¡Error!',
        text: 'Los siguientes errores ocurrieron:\n' + mensajeErrores,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'formularioCaracterizacion.php');
        }
    });
};
//DEFINICION DE FUNCIONES PARA ALERTAS
//Función para alertas de Login
function mostrarAlertasLogin(title, text, icon, confirmButtonText){
    console.log(title);
    console.log(text);
    console.log(confirmButtonText);
    console.log(icon);
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'index.php');
        }
    });
}
//Función para alertas de actualizacion de perfil
function mostrarAlertasUsuario(title, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'usuario.php');
        }
    });
};
//Función para alerta de diligenciamiento formulario de caracterizacion por primera vez
function mostrarAlertaCaracterizacion(title, text, icon, confirmButtonText, cancelButtonText){
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    }).then((result) =>{
        if(result.isConfirmed){
            window.location.href = '../pages/formularioCaracterizacion.php';
        } else if(result.dismiss === Swal.DismissReason.cancel){
            window.history.replaceState(null, '', 'usuario.php');
        }
    })
};
//Funcion para alertas del formulario de caracterizacion
function mostrarAlertasFormularioCaracterizacion(title, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'usuario.php');
        }
    });
};
//Funcion para alerta de recuperacion de contraseñas
function mostrarAlertaRecuperarContrasena(title, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'formularioRecuperarContrasena.php');
        }
    });
};