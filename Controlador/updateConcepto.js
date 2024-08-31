$(document).ready(function() {
    // Llama a la función inicial para llenar el select con los conceptos
    getConceptoPago();

$('#eliminar').on('click',limpiarForm);
    // Asociar el evento de cambio del select para obtener el valor actual del concepto
    $('#concepto').on('change', function() {
        let conceptoId = $(this).val();
        if (conceptoId) {
            // Enviar una solicitud AJAX para obtener el valor actual del concepto
            $.ajax({
                type: 'POST',
                url: '../Modelo/getConceptoValor.php',
                data: {
                    idconcepto: conceptoId
                },
                dataType: 'json',
                success: function(response) {
                    $('#valorAbonado').val(response.valorconcepto || ''); // Mostrar el valor actual en el input
                    $('#aniovigencia').val(response.aniovigente || ''); // Mostrar el año actual en el input
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el valor del concepto:', error);
                }
            });
        }
    });

    // Asociar el evento de clic al botón de actualización
    $('#actualizarBtn').on('click', function() {
        let conceptoId = $('#concepto').val();
        let nuevoValor = $('#valorAbonado').val();
        let anioVigencia = $('#aniovigencia').val();

        if (conceptoId && nuevoValor && anioVigencia) {
            // Enviar una solicitud AJAX para actualizar el precio del concepto
            $.ajax({
                type: 'POST',
                url: '../Modelo/updateConcepto.php',
                data: {
                    idconcepto: conceptoId,
                    valorconcepto: nuevoValor,
                    aniovigencia: anioVigencia
                },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    limpiarForm();

                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el concepto:', error);
                }
            });
        } else {
            alert('Por favor complete todos los campos.');
        }
    });

    // Función para obtener los conceptos y llenar el select
    function getConceptoPago() {
        $.ajax({
            type: 'POST',
            url: '../Modelo/getConceptoPago.php',
            dataType: 'json',
            success: function(data) {
                let options = '<option value="" disabled selected>Seleccione Concepto</option>';
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].idconcepto + '">' + data[i].concepto + '</option>';
                }
                $('#concepto').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los conceptos:', error);
            }
        });
    }
});
function limpiarForm(){/*limpia el formulario*/
    console.log("Limpieza de form");
    $('#concepto').prop('value','');
    $('#valorAbonado').prop('value','');
    $('#anioVigencia').prop('value','');
     
   
}