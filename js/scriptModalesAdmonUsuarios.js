    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('contenedorModalEliminar');
        const iconoCerrar = document.getElementById('iconoCerrar');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnEliminar = document.getElementById('btnEliminar');
        let userIdToDelete = null;

        // Mostrar el modal al hacer clic en el botón de eliminar
        document.querySelectorAll('.btnOpenModalEliminar').forEach(button => {
            button.addEventListener('click', (event) => {
                userIdToDelete = button.getAttribute('data-id');
                modal.style.display = 'block';
                console.log('Dentro del evento click:', userIdToDelete);
            });
        });
        console.log('El valor inicial de userIdToDelete:', userIdToDelete);        
        // Cerrar el modal al hacer clic en el icono de cerrar o el botón cancelar
        const closeModal = () => {
            modal.style.display = 'none';
            userIdToDelete = null;
        };
        iconoCerrar.addEventListener('click', closeModal);
        btnCancelar.addEventListener('click', closeModal);
        // Manejar la eliminación del usuario al hacer clic en el botón eliminar del modal
        btnEliminar.addEventListener('click', () => {
            console.log('ID del usuario a eliminar antes del if:', userIdToDelete);
            if (userIdToDelete) {
                console.log('Navegando a la URL para eliminar:', `../php/eliminarUsuario.php?id_user=${userIdToDelete}`);
                window.location.href = `../php/eliminarUsuario.php?id_user=${userIdToDelete}`;
            } else {
                console.error('No se asignó userIdToDelete correctamente.');
            }
        });
    });
