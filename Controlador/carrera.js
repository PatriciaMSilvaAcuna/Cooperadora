$(document).ready(function() {
    iniciar();

    function iniciar() {
        $('#buscarcarrera').on('click', function(event) {
            event.preventDefault(); // Previene la recarga de la página
            buscarCarrera();
        });

        $('#actualizarForm').on('submit', function(event) {
            event.preventDefault(); // Evita la recarga de la página
            actualizarCarrera(); // Llama a la función para actualizar la carrera
        });
    }

    function buscarCarrera() {
        let carrera = $('#nombrecarrera').val();
        console.log('Carrera ingresada:', carrera); // Verifica carrera ingresada

        if (carrera === '') {
            alert('Por favor, complete el campo carrera');
            return; // Detén el envío si algún campo está vacío
        } else { 
            $.ajax({
                type: 'POST',
                data: { nombrecarrera: carrera }, // pasamos la información de la carrera que se capturó del formulario
                url: '../Modelo/buscarCarrera.php', // petición al archivo PHP
                dataType: 'JSON',
                success: function(data) {
                    console.log('Datos recibidos del servidor:', data);
                    $('#nombrecarrera').val('');
                    if (data.error) {
                        // Muestra el mensaje de error si no se encuentra la carrera
                        alert(data.error);
                    } else {
                        // Itera sobre los datos obtenidos si no hay error
                        for (let i = 0; i < data.length; i++) {
                            let idcarrera = data[i].idcarrera;
                            let nombrecarrera = data[i].carrera;
                            let estado = data[i].estado;
                            
                            // Carga los datos en el formulario
                            cargarInputCarrera(idcarrera, nombrecarrera, estado);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos de la carrera:', error);
                    alert('Error al obtener los datos de la carrera');
                }
            });
        }
    }

    function cargarInputCarrera(idcarrera, nombrecarrera, estado) {
        console.log('Cargando datos en el formulario:', {
            idcarrera: idcarrera,
            nombrecarrera: nombrecarrera,
            estado: estado,
        });

        // Establece el valor de los campos de la carrera en el formulario
        $('#idcarrera').val(idcarrera);
        $('#carrera').val(nombrecarrera);

        // Asigna el estado del checkbox
        $('#carreraactiva').prop('checked', estado == 1);

        alert('Datos cargados correctamente.');
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
