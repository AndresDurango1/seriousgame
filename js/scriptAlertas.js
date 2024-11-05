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
function mostrarAlerta(title, text, icon, confirmButtonText) {
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
