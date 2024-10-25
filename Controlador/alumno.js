$(document).ready(function() {
    iniciar(); // Llama a la función iniciar cuando el documento esté listo

    function iniciar() {
        getMetodosPago();
        getConceptoPago();
        $('#eliminar').on('click', limpiarForm);
        $('#getDatosAlumnos').on('click', getDatosAlumnos);
        $('#altaPago').off('click').on('click', function(event) {
            event.preventDefault(); // Prevenir comportamiento por defecto
            setPago(); // Llama a la función para realizar el pago
        });
    }

    function setPago() {
        let valorAbonado = $('#valorAbonado').val();
        let fecha = $('#fecha').val();
        let metodoPago = $('#metodoPago').val();
        let dni = $('#dni').val();
        let concepto = $('#concepto').val();

        // Validar que el DNI solo contenga números y que tenga una longitud adecuada
        if (!/^\d+$/.test(dni) || dni.length < 7 || dni.length > 8) {
            alert('El DNI ingresado no es válido. Debe contener solo números y tener entre 7 y 8 dígitos.');
            return;
        }

        if (valorAbonado && fecha && metodoPago && dni && concepto) {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getAlumnoId.php',
                data: { dni: dni },
                dataType: 'json',
                success: function(response) {
                    if (response.idalumno) {
                        $.ajax({
                            type: 'POST',
                            url: '../Modelo/setPago.php',
                            data: {
                                fecha: fecha,
                                valorAbonado: valorAbonado,
                                metodoPago: metodoPago,
                                concepto: concepto,
                                idalumno: response.idalumno
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message); // Mostrar mensaje de éxito
                                    
                                    // Limpiar el formulario primero
                                    limpiarForm();

                                    // Descargar el PDF automáticamente después
                                    descargarPDF();
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al registrar el pago:', xhr.responseText);
                            }
                        });
                    } else {
                        // Aquí se agrega el mensaje que se desea mostrar
                        alert('El DNI ingresado no existe en nuestros registros.'); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el ID del alumno:', xhr.responseText);
                }
            });
        } else {
            alert('Por favor complete todos los campos y seleccione un alumno.');
        }
    }

    // El resto de las funciones permanece igual...
});
