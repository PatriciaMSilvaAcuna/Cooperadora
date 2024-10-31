function verificarSesion() {
    $.ajax({
        url: '../Modelo/verificar_sesion.php', // Un archivo PHP que devuelva el estado de la sesión
        method: 'GET',
        success: function(data) {
            if (!data.sesionActiva) {
                window.location.href = '../index.html'; // Redirigir si la sesión no está activa
            }
        },
        error: function() {
            console.error('Error al verificar la sesión');
        }
    });
}

// Llamar a esta función al cargar la página
$(document).ready(function() {
    verificarSesion();
});
