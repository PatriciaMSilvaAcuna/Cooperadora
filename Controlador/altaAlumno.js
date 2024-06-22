// altaAlumno.js
$(document).ready(function () {
    // Escuchamos el click del botón "Dar de Alta"
    $("#darAlta").click(function () {
        // Serializamos los datos del formulario
        var formData = $("#formulario").serialize();

        // Enviamos los datos mediante AJAX al archivo PHP
        $.ajax({
            type: "POST",
            url: "../Modelo/altaAlumno.php", // Ruta al archivo PHP que procesa la inserción
            data: formData,
            dataType: "json",
            success: function (response) {
                // Mostramos la respuesta del servidor
                alert(response);
                // Podrías hacer más cosas aquí, como limpiar el formulario o redirigir
            },
            error: function (xhr, status, error) {
                // Manejo de errores
                alert("Error: " + error);
            }
        });
    });
});
