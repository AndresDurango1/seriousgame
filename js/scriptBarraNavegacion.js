document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remover la clase 'active' de todos los enlaces
            navLinks.forEach(nav => nav.classList.remove('active'));
            
            // Agregar la clase 'active' al enlace seleccionado
            this.classList.add('active');
        });
    });
});
