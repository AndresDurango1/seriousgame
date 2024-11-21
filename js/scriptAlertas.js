const params = new URLSearchParams(window.location.search);
//Alertas para la pagina de Usuario
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
}
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
    mostrarAlertasCaracterizacion(title, text, icon, confirmButtonText);
}
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
}
//DEFINICION DE FUNCIONES PARA ALERTAS
function mostrarAlertasUsuario(title, text, icon, confirmButtonText) {
    /*console.log('Title:', title);
    console.log('Text:', text);
    console.log('Icon:', icon);
    console.log('ConfirmButtonText:', confirmButtonText);*/
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.replaceState(null, '', 'usuario.php');
        }
    });
}
function mostrarAlertasCaracterizacion(title, text, icon, confirmButtonText) {
    /*console.log('Title:', title);
    console.log('Text:', text);
    console.log('Icon:', icon);
    console.log('ConfirmButtonText:', confirmButtonText);*/
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../pages/formularioCaracterizacion.php';
        }
    });
};