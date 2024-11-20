// Espera a que el DOM esté completamente cargado antes de ejecutar el código
$(document).ready(function() {
    // Vincula el evento click al botón Dar de Alta
    $('#darAlta').on('click', function(event) {
         event.preventDefault(); // Previene el comportamiento predeterminado del botón (enviar el formulario)
        console.log('Botón Dar de Alta clickeado');// Mensaje de depuración para indicar que el botón fue clickeado
        // Llama a la función altacarrera para procesar la solicitud de alta
        altacarrera();
    });

// Función para manejar el alta de la carrera
function altacarrera() {
   // Obtiene el valor ingresado en el campo 'nueva_carrera' 
   let nueva_carrera = $('#nueva_carrera').val();

        // Verifica si algún campo requerido está vacío
        if (nueva_carrera === '') {
            alert('Por favor, completa la nueva carrera.');// Muestra un mensaje de advertencia si está vacío
            return; // Detiene el envío si algún campo está vacío
        }
         // Serializa los datos del formulario (convierte los valores de los campos a un formato URL codificado)
        let data = $('#formulario').serialize();
        console.log("Datos enviados:", data); // Imprime los datos que se enviarán al servidor en la consola
        // Realiza la solicitud AJAX al archivo PHP para dar de alta la nueva carrera
        $.ajax({
            type: 'POST', // Método HTTP utilizado: POST
            url: '../Modelo/altaCarrera.php', // URL del archivo PHP que maneja la lógica del alta
            data: data, // Datos del formulario a enviar
            dataType: 'JSON', // Esperamos recibir una respuesta en formato JSON
            success: function(response) {
                // Si la solicitud es exitosa, procesamos la respuesta del servidor
                console.log("altacarrera", response); // Verifica los datos de la respuesta en la consola
                alert("Carrera dada de alta");// Muestra un mensaje de éxito al usuario
                limpiarForm();// Limpia el formulario después de dar de alta la carrera
            },
            error: function(xhr, status, error) {
                 // Si ocurre un error en la solicitud, mostrarlo en la consola
                console.error("Error en la solicitud:", error);
                // Mostrar un mensaje de error al usuario
                alert("Ocurrió un error al dar de alta la carrera.");
            }
        });
    }
// Función para limpiar los campos del formulario
function limpiarForm() {
        $('#formulario')[0].reset(); // Resetea el formulario
    }
});
