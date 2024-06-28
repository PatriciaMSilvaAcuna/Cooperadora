$(document).ready(function() {
    $('#formBuscarAlumno').submit(function(event) {
        event.preventDefault(); // Evitar el envío por defecto del formulario
        var dni = $('#dni').val(); // Obtener el DNI ingresado
        // Realizar solicitud AJAX para buscar al alumno
        $.ajax({
            type: 'GET',
            url: '../Modelo/inscripcionAlumnoCarrera.php',
            data: { dni: dni },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#id-alumno').val(response.alumno.id_alumno);
                    $('#nombre').val(response.alumno.nombre);
                    $('#apellido').val(response.alumno.apellido);
                    $('#dni2').val(response.alumno.dni);
                    // Llenar dinámicamente las opciones del select de carreras
                    var selectCarreras = $('#carreras');
                    selectCarreras.empty(); // Limpiar opciones actuales
                    $.each(response.carreras, function(index, carrera) {
                        selectCarreras.append('<option value="' + carrera.id_carrera + '">' + carrera.carrera + '</option>');
                    });
                    $('#fieldset-alumno').show(); // Mostrar el campo del alumno
                } else {
                    $('#mensaje').text(response.message);
                    $('#fieldset-alumno').hide(); // Ocultar el campo del alumno si hay error
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Manejar el evento clic del botón de inscripción a carrera
    $('#nueva-inscrip').click(function() {
        var idAlumno = $('#id-alumno').val();
        var idCarrera = $('#carreras').val();
        // Realizar solicitud AJAX para realizar la inscripción
        $.ajax({
            type: 'POST',
            url: '../Modelo/inscripcionAlumnoCarrera.php',
            data: { id_alumno: idAlumno, id_carrera: idCarrera },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#mensaje').text(response.message);
                } else {
                    $('#mensaje').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });
});
