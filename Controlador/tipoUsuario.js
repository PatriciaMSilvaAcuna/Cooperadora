$(document).ready(function() {
    $('#volverBtn').click(function() {
        redirectBasedOnUserType()});
     $('#logoImage').click(function() {
        redirectBasedOnUserType();
    });

    function redirectBasedOnUserType() {
        $.ajax({
            type: 'GET',
            url: '../Modelo/tipoUsuario.php',
            dataType: 'json',
            success: function(response) {
                if (response.tipoUsuario === 0) {
                    window.location.href = '../Vista/gestionarAlumno.html'; 
                } else if (response.tipoUsuario === 1) {
                    window.location.href = '../Vista/gestionarOperador.html'; 
                } else {
                    window.location.href = '../Vista/error.html'; // Default or error page
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener el tipo de usuario:', error);
                window.location.href = '../Vista/error.html'; // Default or error page
            }
        });
    }
});
