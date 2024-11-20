// Función que redirige a diferentes páginas dependiendo del tipo de usuario
function redirectBasedOnUserType() {
     // Realiza una solicitud AJAX para obtener el tipo de usuario desde el servidor
    $.ajax({
        type: 'GET', // Se usa el método GET para obtener la información
        url: '../Modelo/tipoUsuario.php', // La URL del script que obtiene el tipo de usuario
        dataType: 'json',  // Se espera una respuesta en formato JSON
        success: function(response) {
            // Si la solicitud es exitosa, se procesa la respuesta
             // Dependiendo del tipo de usuario, se redirige a una página diferente
            if (response.tipoUsuario === 0) {
                // Si el tipo de usuario es 0 (Alumno), se redirige a la página de gestionarAlumno
                window.location.href = '../Vista/gestionarAlumno.html'; 
            } else if (response.tipoUsuario === 1) {
                // Si el tipo de usuario es 1 (Operador), se redirige a la página de gestionarOperador
                window.location.href = '../Vista/gestionarOperador.html'; 
            } else {
                  // Si el tipo de usuario no es 0 ni 1, se redirige a una página de error
                window.location.href = '../Vista/error.html'; // Página predeterminada o de error
            }
        },
        error: function(xhr, status, error) {
            // Si ocurre un error en la solicitud AJAX, se muestra un mensaje de error en la consola
            console.error('Error al obtener el tipo de usuario:', error);
            // Y se redirige a una página de error
            window.location.href = '../Vista/error.html'; // Página predeterminada o de error
        }
    });
}
// Código que se ejecuta cuando el DOM está completamente cargado
$(document).ready(function() {
    // Evento que se ejecuta cuando se hace clic en el botón con id 'volverBtn'
    $('#volverBtn').click(function() {
         // Llama a la función 'redirectBasedOnUserType' para redirigir según el tipo de usuario
        redirectBasedOnUserType();
    });

// Evento que se ejecuta cuando se hace clic en el logo de la página
    $('#logoImage').click(function() {
       // Llama a la misma función 'redirectBasedOnUserType' para redirigir según el tipo de usuario 
        redirectBasedOnUserType();
    });
});
