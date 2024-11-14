// Espera a que el documento esté completamente cargado
$(document).ready(function() {
    iniciar(); // Llama a la función iniciar cuando el documento esté listo

// Función principal de inicialización
function iniciar() {
        getMetodosPago(); // Carga los métodos de pago en el select correspondiente
        getConceptoPago(); // Carga los conceptos de pago en el select correspondiente

         // Asigna eventos a los botones
        $('#eliminar').on('click', limpiarForm); // Limpia el formulario cuando se hace clic en el botón "eliminar"
        $('#getDatosAlumnos').on('click', getDatosAlumnos); // Obtiene datos de alumnos al hacer clic en "getDatosAlumnos"
        $('#altaPago').off('click').on('click', function(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado de envío del formulario
            setPago(); // Llama a la función para realizar el registro del pago
        });
    }

// Función para registrar un pago en el sistema
function setPago() {
        // Recoge los valores de los campos del formulario
        let valorAbonado = $('#valorAbonado').val();
        let fecha = $('#fecha').val();
        let metodoPago = $('#metodoPago').val();
        let dni = $('#dni').val();
        let concepto = $('#concepto').val();

        // Validación del campo DNI: solo debe contener números y tener entre 7 y 8 dígitos
        if (!/^\d+$/.test(dni) || dni.length < 7 || dni.length > 8) {
            alert('El DNI ingresado no es válido. Debe contener solo números y tener entre 7 y 8 dígitos.');
            return; // Detiene la ejecución si el DNI es inválido
        }
        // Verifica si todos los campos requeridos están completos
        if (valorAbonado && fecha && metodoPago && dni && concepto) {
        // Realiza una solicitud AJAX para obtener el ID del alumno a partir del DNI
            $.ajax({
                type: 'POST',
                url: '../Modelo/getAlumnoId.php',
                data: { dni: dni },
                dataType: 'json',
                success: function(response) {
                    // Si se encuentra el ID del alumno, realiza el registro del pago
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
                                    limpiarForm();// Limpia el formulario después de un registro exitoso
                                    descargarPDF();// Descargar el PDF automáticamente después
                                } else {
                                    alert(response.message); // Muestra mensaje de error
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al registrar el pago:', xhr.responseText); // Registro de error en consola
                            }
                        });
                    } else {
                        // Mensaje de alerta si el DNI no se encuentra en los registros
                        alert('El DNI ingresado no existe en nuestros registros.'); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el ID del alumno:', xhr.responseText);  // Registro de error en consola
                }
            });
        } else {
            alert('Por favor complete todos los campos y seleccione un alumno.'); // Mensaje si faltan datos
        }
    }


// Función para descargar el PDF de comprobante
function descargarPDF() {
        // Crear un enlace temporal para descargar el PDF
        var link = document.createElement('a');
        link.href = '../Modelo/pdf.php'; // URL para generar el PDF
        link.download = 'comprobante_pago.pdf'; // Nombre del archivo PDF
        link.click();  // Activa la descarga
    }


// Función para limpiar el formulario después de completar una acción
function limpiarForm() {
        $('#dni').val(''); // Limpia el campo DNI
        $('#fecha').val(''); // Limpia el campo fecha
        $('#valorAbonado').val(''); //limpia el campo valor abonado
        $('#metodoPago').val(''); // Restaura el select de método de pago
        $('#concepto').val(''); // Restaura el select de concepto de pago
        $('#alumno').html(''); // Limpia los datos del alumno en pantalla
    }


// Función para obtener datos del alumno según el DNI ingresado
function getDatosAlumnos() {
    let dni = $('#dni').val(); // Captura el DNI ingresado
    $('#mensajeNoDatos').hide(); // Oculta el mensaje de "no datos" antes de la búsqueda
      // Verifica si hay un DNI ingresado
    if (dni) {
         // Realiza una solicitud AJAX para obtener datos del alumno
        $.ajax({
            type: 'POST',
            url: '../Modelo/getAlumno.php',
            data: { dni: dni },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    // Genera una tabla con la información del alumno si se encuentran datos
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
                    $('#alumno').html(tabla); // Muestra la tabla en el contenedor "alumno"
                } else {
                    // Muestra un mensaje si no se encuentran datos para el DNI ingresado
                    $('#mensajeNoDatos').show();
                    $('#alumno').html(''); // Limpia cualquier tabla previa
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del alumno:', error); // Registro de error en consola
            }
        });
    } else {
        alert('Por favor ingrese un DNI.'); // Mensaje de alerta si no se ingresa un DNI
    }
}
// Función para obtener los métodos de pago y llenar el select
function getMetodosPago() {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getMetodosPago.php',  // URL de la API para obtener los métodos de pago
                dataType: 'json', 
                success: function(data) {
                    let options = '<option value="" disabled selected>Método de pago</option>'; // Opción predeterminada
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idmetodopago + '">' + data[i].metodopago + '</option>';
                    }
                    $('#metodoPago').html(options); // Llena el select con las opciones obtenidas
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los métodos de pago:', error); // Registro de error en consola
                }
            });
}
       
// Función para obtener los conceptos de pago y llenar el select
function getConceptoPago() {
            $.ajax({
                type: 'POST',
                url: '../Modelo/getConceptoPago.php', // URL de la API para obtener los conceptos de pago
                dataType: 'json', 
                success: function(data) {
                    let options = '<option value="" disabled selected>Concepto de pago</option>'; // Opción predeterminada
                    for (let i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].idconcepto + '">' + data[i].concepto + '</option>';
                    }
                    $('#concepto').html(options); // Llena el select con las opciones obtenidas
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los métodos de pago:', error);// Registro de error en consola
                }
            });
        }
});
