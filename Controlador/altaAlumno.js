$(document).ready(function () {
    $('#volverBtn').click(function() {
        redirectBasedOnUserType();
    });

    $("#darAlta").click(function () {
        let nombre = $('#nombre').val().trim();
        let apellido = $('#apellido').val().trim();
        let dni = $('#dni').val().trim();
        let deuda = $('#deuda').val().trim();
        let mail = $('#mail').val().trim();
        let fechaalta = $('#fechaalta').val().trim();

        console.log("Fecha de Alta:", fechaalta);

        // Validaciones básicas
        if (nombre === '' || apellido === '' || dni === '' || mail === '' || fechaalta === '') {
            alert('Por favor, completa todos los campos obligatorios.');
            return;
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

        // Validación de longitud y formato para el campo de DNI
        if (!/^\d{7,8}$/.test(dni)) {
            alert('El DNI debe contener entre 7 y 8 dígitos numéricos.');
            return;
        }

        // Validación de formato para el campo de email
        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(mail)) {
            alert('Por favor, introduce un email válido.');
            return;
        }

        // Validación de formato de fecha (debería estar en YYYY-MM-DD por el tipo date)
        if (!/^\d{4}-\d{2}-\d{2}$/.test(fechaalta)) {
            alert('La fecha debe estar en el formato YYYY-MM-DD.');
            return;
        }

        // Serializamos los datos del formulario
        var formData = $("#formulario").serialize();

        console.log("Datos del formulario:", formData);

        // Enviamos los datos mediante AJAX al archivo PHP
        $.ajax({
            type: "POST",
            url: "../Modelo/altaAlumno.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log("insertAlumno", response);
                alert("Alumno dado de Alta!");

                // Llamamos a la función para limpiar el formulario después del alta
                limpiarForm();
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener los datos del usuario:', xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });
    });
});

// Función para limpiar los campos del formulario
function limpiarForm() {
    $('#nombre').val('');
    $('#apellido').val('');
    $('#dni').val('');
    $('#deuda').val('');
    $('#mail').val('');
    $('#fechaalta').val('');
}
