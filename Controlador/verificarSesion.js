// Función que verifica si la sesión del usuario está activa
function verificarSesion() {
     // Realiza una solicitud AJAX al servidor para verificar el estado de la sesión
    $.ajax({
        url: '../Modelo/verificar_sesion.php', // URL del archivo PHP que devuelve el estado de la sesión
        method: 'GET', // Método HTTP utilizado para hacer la solicitud
        success: function(data) {// Si la solicitud es exitosa
            // Verifica si la sesión no está activa (asumimos que el PHP devuelve un objeto con una propiedad 'sesionActiva')
            if (!data.sesionActiva) {
                // Si la sesión no está activa, redirige al usuario a la página principal (index.html)
                window.location.href = '../index.html'; // Redirigir si la sesión no está activa
            }
        },
        error: function() { // Si ocurre un error en la solicitud AJAX
            // Imprime un mensaje de error en la consola
            console.error('Error al verificar la sesión');
        }
    });
}

// Cuando el documento esté completamente cargado (el DOM listo), se ejecuta la función verificarSesion
$(document).ready(function() {
    verificarSesion();// Llama a la función para verificar el estado de la sesión
});
