function redirigir() {
    // Redirige al html donde se gestiona el reseteo del campo deuda
    window.location.href = 'configuracion.html'; 

}
// resetear.js
document.addEventListener('DOMContentLoaded', function() {
// Función que maneja el evento de hacer clic en el botón de "Resetear"
document.getElementById("resetear").addEventListener("click", function() {
    // Muestra un mensaje de confirmación
    var confirmacion = confirm("¡Advertencia! Estás a punto de poner la deuda de TODOS los alumnos a 0. ¿Estás seguro de que deseas continuar?");
    
    if (confirmacion) {
        // Si el usuario confirma, realizamos la petición AJAX para resetear la deuda
        resetearDeuda();
    }
});
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
const imagenConfig = document.getElementById('configuracionImagen');

    // Cambia la imagen a la versión animada cuando el mouse está encima
    imagenConfig.addEventListener('mouseover', () => {
        imagenConfig.src = '../config.gif';
    });

    // Vuelve a la versión estática cuando el mouse sale
    imagenConfig.addEventListener('mouseout', () => {
        imagenConfig.src = '../config.png';
    });
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