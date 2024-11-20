// Cuando el documento está listo (cargado completamente), se ejecuta la función principal
$(document).ready(function() {
     // Llama a la función 'iniciar' que contiene la lógica principal
    iniciar();

// Función principal que inicia las operaciones necesarias    
function iniciar() {
        // Llama a la función para cargar las carreras desde el servidor
        buscarCarrera();
      

       // Escuchar el cambio de selección en el dropdown de 'nombrecarrera'  
      $('#nombrecarrera').on('change', function() {
        // Obtiene el valor seleccionado (ID de la carrera)
        let idcarreraSeleccionada = $(this).val();
        //Obtiene el valor de la carrera seleccionada
        let nombrecarreraSeleccionada = $(this).find('option:selected').text();

        // Llamar a la función para cargar los datos de la carrera seleccionada
        cargarInputCarrera(idcarreraSeleccionada, nombrecarreraSeleccionada);
    });
        // Escuchar el evento de envío del formulario de actualización
        $('#actualizarForm').on('submit', function(event) {
            event.preventDefault(); // Evita la recarga de la página
            actualizarCarrera(); // Llama a la función para actualizar la carrera
        });
    }

// Función para realizar la búsqueda de carreras desde el servidor
function buscarCarrera() {
        console.log('Iniciando búsqueda de carreras...');
            // Realiza la solicitud AJAX al archivo PHP para obtener las carreras
            $.ajax({
                type: 'POST', // Método de la solicitud: POST
                url: '../Modelo/buscarCarrera.php', // URL del archivo PHP que maneja la búsqueda
                dataType: 'json', // Esperamos recibir una respuesta en formato JSON
                success: function(data) {
                    console.log('Datos recibidos:', data); // Verifica la estructura de los datos recibidos
                     // Crea las opciones para el dropdown de carreras
                    let options = '<option value="" disabled selected>Seleccione Carrera</option>';
                    // Itera sobre las carreras recibidas y añadirlas como opciones en el dropdown
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idcarrera + '">' + data[i].carrera + '</option>';
                    }
                     // Inserta las opciones generadas en el dropdown con id 'nombrecarrera'
                    $('#nombrecarrera').html(options);
                
                    },
                error: function(xhr, status, error) {
                    console.error('Error al obtener las carreras:', error); //Muestra mensaje de error
                }
            });
            
}

// Función para cargar los datos de la carrera seleccionada en los campos del formulario
function cargarInputCarrera(idcarrera, nombrecarrera) {
            console.log('Cargando datos en el formulario:', {
                idcarrera: idcarrera,
                nombrecarrera: nombrecarrera, 
            });
            // Establece el valor de los campos de la carrera en el formulario
            $('#idcarrera').val(idcarrera);
            $('#carrera').val(nombrecarrera); // Asegúrate de que el campo del nombre de la carrera sea correcto
          
}
// Función para actualizar los datos de la carrera en el servidor
function actualizarCarrera() {
        // Serializa los datos del formulario para enviarlos como un string URL codificado
        let formulario = $('#actualizarForm').serialize();
        // Obtiene el ID de la carrera desde el campo oculto
        let idcarrera = $('#idcarrera').val();
         // Añade el ID de la carrera a los datos del formulario
        formulario += "&idcarrera=" + idcarrera;
        console.log("Datos enviados:", formulario); // Verificar los datos que se enviarán
        // Realiza la solicitud AJAX al archivo PHP para actualizar los datos de la carrera
        $.ajax({
            type: 'POST', // Método de la solicitud: POST
            url: '../Modelo/modificarCarrera.php', // URL del archivo PHP que maneja la actualización
            data: formulario, // Datos del formulario a enviar
            dataType: 'JSON',  // Esperamos recibir una respuesta en formato JSON
            success: function(response) {
                if (response.success) {
                     // Si la actualización fue exitosa, mostrar un mensaje
                    alert('Datos actualizados correctamente.');
                    limpiarForm();
                } else {
                    // Si hubo un error en la actualización, mostrar el mensaje de error
                    alert(response.message || 'Error al actualizar los datos.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar la carrera:', status, error); // Muestra el error en la consola
                // Muestra un mensaje de alerta con los detalles del error
                alert('Error al actualizar los datos. Estado: ' + status + ', Error: ' + error);
            }
        });
    }
// Función para limpiar los campos del formulario    
function limpiarForm() {
        // Restablece el formulario a su estado inicial (vacío) 
        $('#actualizarForm')[0].reset();
    }
});
