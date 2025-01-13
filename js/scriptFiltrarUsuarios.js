async function filtrarTabla() {
    const input = document.getElementById("searchInput").value;
    const response = await fetch(`../php/filtrarUsuarios.php?q=${encodeURIComponent(input)}`);
    const usuarios = await response.json();
    const tbody = document.querySelector("#tablaUsuarios tbody");
    tbody.innerHTML = ""; // Limpiar la tabla

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
                <a href="eliminarUsuario.php?id_user=${usuario.id_usuario}" class="btnAccion btnEliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
            </td>
        `;
        tbody.appendChild(row);
    });
}
