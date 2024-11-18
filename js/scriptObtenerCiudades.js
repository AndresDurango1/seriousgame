document.getElementById('inputDepartamento').addEventListener('change', function() {
    const departamentoId = this.value;
    const ciudadSelect = document.getElementById('inputCiudad');
    ciudadSelect.innerHTML = '<option value="" disabled selected>Por favor selecciona</option>';

    if (departamentoId) {
        fetch('../php/obtenerCiudades.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_departamento=${departamentoId}`
        })
        .then(response => response.json())
        .then(data => {
            // Añadir las opciones de ciudad al select
            data.forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad.id_ciudad;
                option.textContent = ciudad.ciudad;
                ciudadSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});

