// Obtener el botón de menú hamburguesa y el contenedor de enlaces
const menuToggle = document.getElementById('menu-toggle');
const navLinks = document.getElementById('nav-links');
// Añadir un evento de clic al botón hamburguesa
menuToggle.addEventListener('click', () => {
    // Alternar la clase 'active' para mostrar u ocultar el menú
    navLinks.classList.toggle('active');
});
function abrirModal() {
    document.getElementById('modalActualizarPerfil').style.display = 'block';
}

function cerrarModal() {
    document.getElementById('modalActualizarPerfil').style.display = 'none';
}
// Cerrar el modal al hacer clic fuera de él
window.onclick = function (event) {
    const modal = document.getElementById('modalActualizarPerfil');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

