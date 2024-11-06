const params = new URLSearchParams(window.location.search);
if (params.has('actualizado') || params.has('contrasena')) {
    let title, text, icon, confirmButtonText;

    switch (true) {
        case params.has('actualizado'):
            title = '¡Éxito!';
            text = 'Los cambios se han guardado correctamente.';
            icon = 'success';
            confirmButtonText = 'Aceptar';
            break;

        case params.has('contrasena'):
            title = '¡Error!';
            text = 'Las contraseñas no coinciden. Por favor, intenta de nuevo.';
            icon = 'error';
            confirmButtonText = 'Aceptar';
            break;
    }
    mostrarAlerta(title, text, icon, confirmButtonText);
}
if (params.has('caracterizacion')) {
    let title, text, icon, confirmButtonText;
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
}
function mostrarAlertaActualizacion(title, text, icon, confirmButtonText) {
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
function mostrarAlertaCaracterizacion(title, text, icon, confirmButtonText, cancelButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
        showCancelButton: true,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../pages/formularioCaracterizacion.php';
        } else if (result.isDismissed) {
            window.location.href = '../pages/usuario.php';
        }
    });
};