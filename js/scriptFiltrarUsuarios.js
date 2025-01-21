async function filtrarTabla() {
    const input = document.getElementById("searchInput").value.trim();
    let url;

    if (input === "") {
        url = `../php/obtenerTodosUsuarios.php`;
    } else {
        url = `../php/filtrarUsuarios.php?q=${encodeURIComponent(input)}`;
    }
    try {
        const response = await fetch(url);
        const usuarios = await response.json();
        const tbody = document.querySelector("#tablaUsuarios tbody");
        tbody.innerHTML = "";
        // Filtrar los usuarios que coinciden con el nombre o apellido
        const filteredUsuarios = usuarios.filter(usuario => {
            const nombreCompleto = usuario.nombre_completo.toLowerCase();
            const apellidoCompleto = usuario.apellido_completo.toLowerCase();
            const searchTerm = input.toLowerCase();
            return nombreCompleto.includes(searchTerm) || apellidoCompleto.includes(searchTerm);
        });
        filteredUsuarios.forEach(usuario => {
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
    } catch (error) {
        console.error("Error al cargar los usuarios:", error);
    }
}

function recargarPaginaSiVacio() {
    var searchInput = document.getElementById('searchInput');
    if (searchInput.value.trim() === '') {
        location.reload();
    }
}
