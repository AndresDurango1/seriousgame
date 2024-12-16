const btnMenuHamburguesa = document.getElementById('btnMenuHamburguesa');
const contenedorBarraLateral = document.getElementById("barraLateral");
const contendedoPrincipalContent = document.getElementById("contenedorPrincipal-content");

btnMenuHamburguesa.addEventListener('click', () => {
    if (contenedorBarraLateral.style.display === 'flex') {
        contenedorBarraLateral.style.display = 'none';
        contendedoPrincipalContent.style.display = 'block';
    } else {
        contenedorBarraLateral.style.display = 'flex';
        contendedoPrincipalContent.style.display = 'none';
    }
});
