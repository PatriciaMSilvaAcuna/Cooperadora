
// Espera a que el contenido del DOM se haya cargado completamente antes de ejecutar el código
document.addEventListener('DOMContentLoaded', () => {
      // Escucha el evento de envío del formulario con el id 'buscarForm'
    document.getElementById('buscarForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir la recarga de la página
         
        // Obtniene el valor del campo de texto con el id 'Dni_usuario' (el DNI ingresado por el usuario) 
        let Dni_usuario = document.getElementById('Dni_usuario').value;

        // Envia una solicitud HTTP POST al archivo PHP 'buscar_usuario.php' con el DNI del usuario
        fetch('../Modelo/buscar_usuario.php', {
            method: 'POST', // Método HTTP utilizado (POST)
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'// Tipo de contenido: datos en formato URL codificado
            },
            body: 'Dni_usuario=' + encodeURIComponent(Dni_usuario) // Pasar el DNI como parámetro codificado para evitar problemas con caracteres especiales
        })
        .then(response => response.json()) // Convierte la respuesta del servidor a formato JSON
        .then(data => {
            // Verifica si la respuesta del servidor indica que la búsqueda fue exitosa
            if (data.estado === 'OK') {
                // Si el estado es OK, redirigir al usuario a la página de actualización con los datos del usuario
                window.location.href = `../Vista/actualizarUsuario.html?Dni_usuario=${Dni_usuario}&usuario=${encodeURIComponent(data.Usuario)}&contrasenia=${encodeURIComponent(data.Contrasenia)}`;
            } else {
                // Si el estado no es OK, mostrar un mensaje de error (por ejemplo, "DNI no encontrado")
                document.getElementById('mensaje').textContent = data.msg || 'DNI no encontrado.';
            }
        })
        .catch(error => console.error('Error:', error)); // Captura errores en la solicitud y mostrarlos en la consola
    });
    // Manejar el evento de clic del botón de retorno (con el id 'returnButton')
    const returnButton = document.getElementById('returnButton');
    if (returnButton) {
         // Si el botón de retorno existe en el DOM, agregar un listener para el click
        returnButton.addEventListener('click', (event) => {
            event.preventDefault(); // Prevenir cualquier acción predeterminada

            window.location.href = '../Vista/gestionarUsuario.html'; // Redirige a gestionUsuario.html
        });
    }
});
