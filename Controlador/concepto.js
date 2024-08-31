$(document).ready(function() {
    iniciar(); // Llama a la función iniciar cuando el documento esté listo

    // Función para iniciar el formulario
    function iniciar() {
        getConceptoPago(); // Llama a la función getConceptoPago
        $('#concepto').on('change', obtenerValorConcepto); // Asocia el evento change al select concepto
    }

    // Función para obtener los conceptos de pago y llenar el select
    function getConceptoPago() {
        $.ajax({
            type: 'POST',
            url: '../Modelo/getConceptoPago.php', 
            dataType: 'json', 
            success: function(data) {
                let options = '<option value="" disabled selected>Seleccione Concepto de pago</option>'; // Opción predeterminada
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].idconcepto + '">' + data[i].concepto + '</option>';
                }
                $('#concepto').html(options); // Llena el select con las opciones
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los conceptos de pago:', error); // Mostrar mensaje de error
            }
        });
    }

    // Función para obtener el valor del concepto seleccionado y actualizar el input
    function obtenerValorConcepto() {
        let idConcepto = $('#concepto').val();
        if (idConcepto) {
            $.ajax({
                type: 'POST',
                url: '../Modelo/concepto.php', // Archivo PHP que obtiene el valor del concepto
                data: { idconcepto: idConcepto },
                dataType: 'json',
                success: function(data) {
                    if (data && data.valorconcepto) {
                        $('#valorAbonado').val(data.valorconcepto);
                    } else {
                        $('#valorAbonado').val(''); // Limpiar el campo si no hay valor
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el valor del concepto:', error); // Mostrar mensaje de error
                }
            });
        } else {
            $('#valorAbonado').val(''); // Limpiar el campo si no hay concepto seleccionado
        }
    }
});
