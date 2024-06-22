// altaAlumno.js
$(document).ready(function () {
    // Escuchamos el click del botón "Dar de Alta"
    $("#darAlta").click(function (){

    let nombre = $('#nombre').val().trim();
    let apellido = $('#apellido').val().trim();
    let dni = $('#dni').val().trim();
    if (nombre === '' || apellido === '' || dni === '') {
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
    if (!/^\d{7,8}$/.test(dni)) {
    alert('El DNI debe contener entre 7 y 8 dígitos numéricos.');
    return;

    }
        // Serializamos los datos del formulario
        var formData = $("#formulario").serialize();
        // Imprime la respuesta en la consola
        console.log("Respuesta del servidor:", formData);

        // Enviamos los datos mediante AJAX al archivo PHP
        $.ajax({
            type: "POST",
            url: "../Modelo/altaAlumno.php", // Ruta al archivo PHP que procesa la inserción
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log("insertAlumno",response)
                // Mostramos la respuesta del servidor
                alert("Alumno dado de Alta!");
                  limpiarForm();
                
            },
            error: function (xhr, status, error) {
                 // Mostrar mensaje de error
                console.error('Error al obtener los datos del usuario:', error);
              
                // Manejo de errores
                alert("Error: " + error);
                
            }

        });
    });
});

function limpiarForm(){/*limpia el formulario*/
    console.log("Limpieza de form");
    $('#nombre').prop('value','');
    $('#apellido').prop('value','');
    $('#dni').prop('value','');
  //  $('#deuda').prop('value','');
}
