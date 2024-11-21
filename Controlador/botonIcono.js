$(document).ready(function() {
    $('#logoImage').click(function() {
        homeBack(); // Llamamos a la función homeBack al hacer clic en el logo
    });

    // Función que realiza la redirección dependiendo del tipo de usuario
    function homeBack() {
        $.ajax({
            type: 'GET',
            url: '../Modelo/tipoUsuario.php',
            dataType: 'json',
            success: function(response) {
                // Comprobamos el tipo de usuario para redirigir a la página correspondiente
                if (response.tipoUsuario === 0) {
                    window.location.href = '../Vista/accesoAceptadoAdmin.html'; 
                } else if (response.tipoUsuario === 1) {
                    window.location.href = '../Vista/accesoAceptadoOperador.html'; 
                } else {
                    window.location.href = '../Vista/error.html'; 
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener el tipo de usuario:', error);
                window.location.href = '../Vista/error.html'; // Redirección en caso de error
            }
        });
    }
});
