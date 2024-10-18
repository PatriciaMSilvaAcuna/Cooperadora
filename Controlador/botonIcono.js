$(document).ready(function() {
     $('#logoImage').click(function() {
        homeBack();
    });

    function homeBack() {
        $.ajax({
            type: 'GET',
            url: '../Modelo/tipoUsuario.php',
            dataType: 'json',
            success: function(response) {
                if (response.tipoUsuario === 0) {
                    window.location.href = '../Vista/accesoAceptadoAdmin.html'; 
                } else if (response.tipoUsuario === 1) {
                    window.location.href = '../Vista/accesoAceptadoOperador.html'; 
                } else {
                    window.location.href = '../Vista/error.html'; // ola ola
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener el tipo de usuario:', error);
                window.location.href = '../Vista/error.html'; // ola ola
            }
        });
    }
});
