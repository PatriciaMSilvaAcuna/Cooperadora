

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('buscarForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir la recarga de la página

        let Dni_usuario = document.getElementById('Dni_usuario').value;

        fetch('../Modelo/buscar_usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'Dni_usuario=' + encodeURIComponent(Dni_usuario)
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'OK') {
                // Redirigir a actualizarUsuario.html con los datos del DNI
                window.location.href = `../Vista/actualizarUsuario.html?Dni_usuario=${Dni_usuario}&usuario=${encodeURIComponent(data.Usuario)}&contrasenia=${encodeURIComponent(data.Contrasenia)}`;
            } else {
                document.getElementById('mensaje').textContent = data.msg || 'DNI no encontrado.';
            }
        })
        .catch(error => console.error('Error:', error));
    });
    // Manejar el botón de retorno
    const returnButton = document.getElementById('returnButton');
    if (returnButton) {
        returnButton.addEventListener('click', (event) => {
            event.preventDefault(); // Prevenir cualquier acción predeterminada

            window.location.href = '../Vista/gestionarUsuario.html'; // Redirigir a gestionUsuario.html
        });
    }
});
