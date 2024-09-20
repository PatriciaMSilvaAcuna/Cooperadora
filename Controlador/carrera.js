$(document).ready(function() {
    iniciar();

    function iniciar() {
        buscarCarrera();
      // Escuchar cuando se cambia la carrera en el dropdown
      $('#nombrecarrera').on('change', function() {
        // Obtener el valor seleccionado (ID de la carrera)
        let idcarreraSeleccionada = $(this).val();
        let nombrecarreraSeleccionada = $(this).find('option:selected').text();

        // Llamar a la función para cargar los datos de la carrera seleccionada
        cargarInputCarrera(idcarreraSeleccionada, nombrecarreraSeleccionada);
    });
        $('#actualizarForm').on('submit', function(event) {
            event.preventDefault(); // Evita la recarga de la página
            actualizarCarrera(); // Llama a la función para actualizar la carrera
        });
    }

    function buscarCarrera() {
        console.log('Iniciando búsqueda de carreras...');
            $.ajax({
                type: 'POST',
                url: '../Modelo/buscarCarrera.php', // petición al archivo PHP
                dataType: 'json',
                success: function(data) {
                    console.log('Datos recibidos:', data); // Verifica la estructura de los datos recibidos
                    let options = '<option value="" disabled selected>Seleccione Carrera</option>';
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idcarrera + '">' + data[i].carrera + '</option>';
                    }
                    $('#nombrecarrera').html(options);
                
                    },
                error: function(xhr, status, error) {
                    console.error('Error al obtener las carreras:', error); //Mostrar mensaje de error
                }
            });
            
        }

        function cargarInputCarrera(idcarrera, nombrecarrera) {
            console.log('Cargando datos en el formulario:', {
                idcarrera: idcarrera,
                nombrecarrera: nombrecarrera, 
            });
            // Establece el valor de los campos de la carrera en el formulario
            $('#idcarrera').val(idcarrera);
            $('#carrera').val(nombrecarrera); // Asegúrate de que el campo del nombre de la carrera sea correcto
          
        }

    function actualizarCarrera() {
        let formulario = $('#actualizarForm').serialize();
        let idcarrera = $('#idcarrera').val();
        formulario += "&idcarrera=" + idcarrera;
        console.log("Datos enviados:", formulario);

        $.ajax({
            type: 'POST',
            url: '../Modelo/modificarCarrera.php', // petición al archivo PHP para actualización
            data: formulario,
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    alert('Datos actualizados correctamente.');
                    limpiarForm();
                } else {
                    alert(response.message || 'Error al actualizar los datos.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar la carrera:', status, error);
                alert('Error al actualizar los datos. Estado: ' + status + ', Error: ' + error);
            }
        });
    }

    function limpiarForm() {
        $('#actualizarForm')[0].reset();
    }
});
