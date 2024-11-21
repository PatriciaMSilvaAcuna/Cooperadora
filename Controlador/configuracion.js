function redirigir() {
    // Redirige al html donde se gestiona el reseteo del campo deuda
    window.location.href = 'configuracion.html'; 

}
document.addEventListener('DOMContentLoaded', function() {
    // Solo intentar agregar el event listener si el botón existe en el DOM
    const resetearButton = document.getElementById('resetear');
    
    // Comprobar si el botón existe en el DOM antes de agregar el evento
    if (resetearButton) {
        resetearButton.addEventListener('click', function() {
            // Muestra un mensaje de confirmación
            var confirmacion = confirm("¡Advertencia! Estás a punto de poner la deuda de TODOS los alumnos a 0. ¿Estás seguro de que deseas continuar?");
            if (confirmacion) {
                resetearDeuda();  // Llama a la función que hace el reset
            }
        });
    } else {
        console.error("El botón con id 'resetear' no se encontró en el DOM.");
    }
});

function resetearDeuda() {
    console.time("resetearDeuda");
    console.log("Iniciando solicitud AJAX para resetear deuda...");

    // Aquí realizamos una petición AJAX al archivo PHP que manejará el update
    $.ajax({
        url: '../Modelo/configuracion.php',  // Archivo PHP donde se maneja la lógica de base de datos
        type: 'POST',
        data: { action: 'resetear_deuda' },  // Enviamos una acción para que el PHP sepa qué hacer
        success: function(response) {
             console.log("Respuesta del servidor:", response);
            console.timeEnd("resetearDeuda");  // Muestra el tiempo que ha tardado la solicitud
            // Respuesta del servidor (mensaje de éxito o error)
            if (response === 'success') {
                alert('Deudas de los alumnos han sido reiniciadas a 0 correctamente.');
            } else {
                alert('Hubo un error al intentar resetear las deudas.');
            }
        },
        error: function(xhr, status, error) {
            // En caso de que la solicitud falle
            alert('Error en la solicitud. Intenta nuevamente.');
            console.error("Error en AJAX:", error);

        },
        timeout: 5000 // Establece un límite de tiempo para la solicitud (5 segundos)
    });
}

 $(document).ready(function() {
            $('#resetButton').click(function() {
                resetDeuda();
            });

            function resetDeuda() {
                let totalRegistros = 0;
                let registrosActualizados = 0;
                let progreso = 0;

                // Llamada AJAX para ejecutar el procedimiento
                $.ajax({
                    url: 'resetDeuda.php',
                    method: 'POST',
                    data: { action: 'resetear_deuda' },
                    success: function(response) {
                        let data = JSON.parse(response);

                        // Proceso cada lote de datos
                        data.forEach(function(item) {
                            totalRegistros = item.total_registros;
                            registrosActualizados += item.registros_actualizados;
                            progreso = (registrosActualizados / totalRegistros) * 100;

                            // Actualiza la barra de progreso
                            $('#progressBar').css('width', progreso + '%');
                            $('#status').html(`Registros procesados: ${registrosActualizados} de ${totalRegistros}`);
                        });

                        // Finalizar el proceso
                        if (registrosActualizados === totalRegistros) {
                            $('#status').append('<br>Proceso completado.');
                        }
                    },
                    error: function() {
                        $('#status').html('Error en la ejecución del procedimiento.');
                    }
                });
            }
});