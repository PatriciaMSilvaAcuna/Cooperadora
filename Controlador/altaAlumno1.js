// altaAlumno.js
$(document).ready(function () {
    // Escuchamos el click del botón "Dar de Alta"
    $("#darAlta").click(function ()
    $("#eliminar").on('click',limpiarForm){

    let nombre = $('#nombre ').val().trim();
    let apellido = $('#apellido').val().trim();
    let dni = $('#dni').val().trim();
    let deuda = $('#deuda').val().trim();
     // Verifica si algún campo requerido está vacío
    if (nombre === '' || apellido === '' || dni === ''|| deuda==='') {
        alert('Por favor, completa todos los campos obligatorios.');
        return; // Detén el envío si algún campo está vacío
    }
    // Validación de longitud y tipología para el campo de nombre
    if (!/^[a-zA-Z]{4,20}$/.test(nombre)) {
        alert('El nombre del alumno debe contener entre 4 y 20 letras.');
        return;
    }
    // Validación de longitud y tipología para el campo de apellido
    if (!/^[a-zA-Z]{4,20}$/.test(apellido)) {
        alert('El apellido del alumno debe contener entre 4 y 20 letras.');
        return;
    }

    // Validación de longitud para el campo de deuda
    if (isNaN(deuda)) {
        alert('Ingresa solo dígitos numéricos.');
        return;
    }

    const numeroParseado = parseFloat(deuda);
    if (numeroParseado <= 0) {
        alert('El número debe ser positivo.');
        return;
    }

    if (!/^\d{7,8}$/.test(dni)) {
    alert('El DNI debe contener entre 7 y 8 dígitos numéricos.');
    return

}

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
                limpiarForm();
            }

        });
    });
});

function limpiarForm(){/*limpia el formulario*/
    console.log("Limpieza de form");
    $('#nombre').prop('value','');
    $('#apellido').prop('value','');
    $('#dni').prop('value','');
    $('#deuda').prop('value','');
}
