async function filtrarTabla() {
    const input = document.getElementById("searchInput").value;
    const response = await fetch(`../php/filtrarUsuarios.php?q=${encodeURIComponent(input)}`);
    const usuarios = await response.json();
    const tbody = document.querySelector("#tablaUsuarios tbody");
    tbody.innerHTML = "";

    usuarios.forEach(usuario => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td><a href="informacionUsuario.php?id_user=${usuario.id_usuario}">${usuario.identificacion}</a></td>
            <td>${usuario.apellido_completo}</td>
            <td>${usuario.nombre_completo}</td>
            <td>${usuario.rol}</td>
            <td>${usuario.celular}</td>
            <td>${usuario.correo}</td>
            <td>
                <a href="actualizarUsuario.php?id_user=${usuario.id_usuario}" class="btnAccion btnActualizar">Actualizar</a>
                <button class="btnAccion btnOpenModalEliminar" data-id="${usuario.id_usuario}">Eliminar</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Delegar el evento de eliminación
    tbody.addEventListener('click', (event) => {
        if (event.target.classList.contains('btnEliminar')) {
            const userId = event.target.getAttribute('data-id');
            const confirmDelete = confirm('¿Estás seguro de que deseas eliminar este usuario?');
            if (confirmDelete) {
                window.location.href = `../php/eliminarUsuario.php?id_user=${userId}`;
            }
        }
    });
}
