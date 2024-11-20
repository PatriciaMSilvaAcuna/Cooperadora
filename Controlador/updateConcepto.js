// Se ejecuta cuando el DOM está completamente cargado
$(document).ready(function() {
    
    // Llama a la función inicial para llenar el select con los conceptos
    getConceptoPago();

    // Asocia el evento de clic al botón 'eliminar' para limpiar el formulario
    $('#eliminar').on('click', limpiarForm);
    
    // Asocia el evento de cambio del select para obtener el valor actual del concepto
    $('#concepto').on('change', function() {
         // Obtiene el valor del concepto seleccionado
        let conceptoId = $(this).val();

        // Si se selecciona un concepto, realiza una solicitud AJAX para obtener el valor y el año de vigencia del concepto
        if (conceptoId) {
            $.ajax({
                type: 'POST', 
                url: '../Modelo/getConceptoValor.php', // URL del script PHP que obtiene el valor y el año de vigencia del concepto
                data: { idconcepto: conceptoId }, // Envia el id del concepto seleccionado
                dataType: 'json',  // Espera una respuesta en formato JSON
                success: function(response) {
                    // Rellena los campos de 'valorAbonado' y 'aniovigencia' con los datos recibidos
                    $('#valorAbonado').val(response.valorconcepto || '');  // Si no hay valor, se deja vacío
                    $('#aniovigencia').val(response.aniovigente || ''); 
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el valor del concepto:', error);
                }
            });
        }
    });

    // Asociar el evento de clic al botón de actualización
    $('#actualizarBtn').on('click', function() {
        // Obtiene los valores de los campos del formulario
        let conceptoId = $('#concepto').val();
        let nuevoValor = $('#valorAbonado').val();
        let anioVigencia = $('#aniovigencia').val();
        
        // Valida el formato del año (debe ser un número entre 2000 y el siguiente año)
        const currentYear = new Date().getFullYear(); // Obtiene el año actual
        const nextYear = currentYear + 1;   // El siguiente año
        const anioNum = parseInt(anioVigencia);  // Convierte el año a número

        // Verifica si el año ingresado es válido (entre 2000 y el siguiente año)
        if (isNaN(anioNum) || anioNum < 2000 || anioNum > nextYear) {
            alert('El año debe ser un número entre 2000 como máximo el año siquiente al actual.');
            return; // Si no es válido, se detiene la ejecución
        }

        // Si todos los campos están completos, realiza la solicitud AJAX para actualizar el concepto
        if (conceptoId && nuevoValor && anioVigencia) {
            $.ajax({
                type: 'POST',
                url: '../Modelo/updateConcepto.php',  // URL del script PHP que actualiza el concepto
                data: {
                    idconcepto: conceptoId, // Envia el id del concepto
                    valorconcepto: nuevoValor, // Envia el nuevo valor del concepto
                    aniovigencia: anioVigencia  // Envia el año de vigencia
                },
                dataType: 'json', // Espera una respuesta en formato JSON
                success: function(response) {
                    // Muestra el mensaje de éxito recibido del servidor
                    alert(response.message);
                    // Limpia el formulario después de actualizar el concepto
                    limpiarForm();
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el concepto:', error); // Si faltan datos, se muestra una alerta
                }
            });
        } else {
            alert('Por favor complete todos los campos.');
        }
    });

    // Función para obtener los conceptos y llenar el select
    function getConceptoPago() {
        $.ajax({
            type: 'POST', // Realiza una solicitud POST
            url: '../Modelo/getConceptoPago.php',  // URL del script PHP que obtiene los conceptos
            dataType: 'json',  // Espera una respuesta en formato JSON
            success: function(data) {
                let options = '<option value="" disabled selected>Seleccione Concepto</option>';
                // Recorre los datos de los conceptos y crea las opciones para el select
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].idconcepto + '">' + data[i].concepto + '</option>';
                }
                // Inserta las opciones generadas en el select con id 'concepto'
                $('#concepto').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los conceptos:', error);
            }
        });
    }
});

// Función para limpiar el formulario de conceptos
function limpiarForm() {
    console.log("Limpieza de form");
    // Restablece los valores de los campos del formulario
    document.getElementById('concepto').value = ''; // Limpia el select de conceptos
    document.getElementById('valorAbonado').value = ''; // Limpia el campo de valor abonado
    document.getElementById('aniovigencia').value = '';  // Limpia el campo de año de vigencia
}
