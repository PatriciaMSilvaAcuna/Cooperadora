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
                        alert('No se encontró un alumno con el DNI ingresado.');
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

    function descargarPDF() {
        // Crear un enlace temporal para descargar el PDF
        var link = document.createElement('a');
        link.href = '../Modelo/pdf.php'; // Cambia esta ruta según sea necesario
        link.download = 'comprobante_pago.pdf'; // Nombre del archivo PDF
        link.click(); // Forzar la descarga del archivo
    }

    function limpiarForm() {
        $('#dni').val('');
        $('#fecha').val('');
        $('#valorAbonado').val('');
        $('#metodoPago').val('');
        $('#concepto').val('');
        $('#alumno').html('');
    }

    function getDatosAlumnos() {
        let dni = $('#dni').val();
        if (dni) {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getAlumno.php',
                data: { dni: dni },
                dataType: 'json',
                success: function(data) {
                    let tabla = "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Deuda</th></tr>";
                    for (let i = 0; i < data.length; i++) {
                        let id = data[i].idalumno;
                        let nombre = data[i].nombre;
                        let apellido = data[i].apellido;
                        let dni = data[i].dni;
                        let deuda = data[i].deuda;
                        tabla += "<tr>" +
                            "<td>" + id + "</td>" +
                            "<td>" + nombre + "</td>" +
                            "<td>" + apellido + "</td>" +
                            "<td>" + dni + "</td>" +
                            "<td>" + deuda + "</td>" +
                            "</tr>";
                    }
                    $('#alumno').html(tabla);
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos del alumno:', error); //Mostrar mensaje de error
                }
            });
        } else {
            alert('Por favor ingrese un DNI.');
        }
    }
        // Función para obtener los métodos de pago y llenar el select
        function getMetodosPago() {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getMetodosPago.php', 
                dataType: 'json', 
                success: function(data) {
                    let options = '<option value="" disabled selected>Método de pago</option>'; // Opción predeterminada
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idmetodopago + '">' + data[i].metodopago + '</option>';
                    }
                    $('#metodoPago').html(options); // Llena el select con las opciones
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los métodos de pago:', error); //Mostrar mensaje de error
                }
            });
        }
        // Función para obtener los conceptos de pago y llenar el select
        function getConceptoPago() {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getConceptoPago.php', 
                dataType: 'json', 
                success: function(data) {
                    let options = '<option value="" disabled selected>Concepto de pago</option>'; // Opción predeterminada
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idconcepto + '">' + data[i].concepto + '</option>';
                    }
                    $('#concepto').html(options); // Llena el select con las opciones
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los métodos de pago:', error); //Mostrar mensaje de error
                }
            });
        }
});
