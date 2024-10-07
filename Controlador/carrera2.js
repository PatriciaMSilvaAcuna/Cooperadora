$(document).ready(function() {
    // Vincular el evento click al botón Dar de Alta
    $('#darAlta').on('click', function(event) {
         event.preventDefault(); 
        console.log('Botón Dar de Alta clickeado');
        altacarrera();
    });

    function altacarrera() {
        let nueva_carrera = $('#nueva_carrera').val();

        // Verifica si algún campo requerido está vacío
        if (nueva_carrera === '') {
            alert('Por favor, completa la nueva carrera.');
            return; // Detén el envío si algún campo está vacío
        }
        let data = $('#formulario').serialize();
        console.log("Datos enviados:", data); // Imprime los datos en la consola

        $.ajax({
            type: 'POST',
            url: '../Modelo/altaCarrera.php', // petición al archivo PHP para alta
            data: data,
            dataType: 'JSON',
            success: function(response) {
                console.log("altacarrera", response);
                alert("Carrera dada de alta");
                limpiarForm();
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud:", error);
                alert("Ocurrió un error al dar de alta la carrera.");
            }
        });
    }

    function limpiarForm() {
        $('#formulario')[0].reset(); // Resetea el formulario
    }
});
