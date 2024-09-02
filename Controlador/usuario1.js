document.addEventListener('DOMContentLoaded', () => {
    // Obtener los parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const Dni_usuario = params.get('dni');
    const correo = params.get('correo');
    const contrasenia = params.get('contrasenia');

    // Rellenar el formulario con los datos obtenidos
    const dniInput = document.getElementById('dni');
    const correoInput = document.getElementById('correo');
    const contraseniaInput = document.getElementById('contrasenia');


    if (dniInput) dniInput.value = Dni_usuario;
    if (correoInput) correoInput.value = correo;
    if (contraseniaInput) contraseniaInput.value = contrasenia;

    const form = document.getElementById('actualizarForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir la recarga de la página

        const formData = new FormData(this);

        fetch('../Modelo/actualizar_usuario.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Datos actualizados correctamente.');
                form.reset(); // Limpiar el formulario
            } else {
                alert('Error al actualizar los datos: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de red o el servidor devolvió un error.');
        });
    });
} else {
    console.error('No se pudo encontrar el formulario con id "actualizarForm".');
}
const returnButton = document.getElementById('returnButton');
if (returnButton) {
    returnButton.addEventListener('click', () => {
        window.location.href = '../Vista/configuracionUsuario.html'; // Redirigir a gestionUsuario.html
    });
}
});
