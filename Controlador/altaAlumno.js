$(document).ready(function () {
    // Al hacer clic en el botón 'volverBtn', redirige según el tipo de usuario
    $('#volverBtn').click(function() {
        redirectBasedOnUserType();
    });

 // Evento para el botón 'darAlta' que da de alta un nuevo alumno
    $("#darAlta").click(function () {
        // Obtiene y limpia los valores de los campos del formulario
        let nombre = $('#nombre').val().trim();
        let apellido = $('#apellido').val().trim();
        let dni = $('#dni').val().trim();
        //let deuda = $('#deuda').val().trim();
        let mail = $('#mail').val().trim();
        let fechaalta = $('#fechaalta').val().trim();

        console.log("Fecha de Alta:", fechaalta);

        // Validación para asegurarse de que todos los campos requeridos estén completos
        if (nombre === '' || apellido === '' || dni === '' || mail === '' || fechaalta === '') {
            alert('Por favor, completa todos los campos obligatorios.');
            return;
        }

        // Validación de nombre: solo letras y espacios, entre 4 y 20 caracteres
        if (!/^[a-zA-ZÑñáéíóúÁÉÍÓÚ\s]{4,20}$/.test(nombre)) {
            alert('El nombre del alumno debe contener entre 4 y 20 letras y puede incluir espacios.');
            return;
        }   

        // Validación de longitud y tipología para el campo de apellido
        if (!/^[a-zA-ZÑñáéíóúÁÉÍÓÚ\s]{4,20}$/.test(apellido)) {
        alert('El apellido del alumno debe contener entre 4 y 20 letras y puede incluir espacios.');
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

         // Serializa los datos del formulario para enviarlos mediante AJAX
        var formData = $("#formulario").serialize();

        console.log("Datos del formulario:", formData);

         // Envía los datos a través de AJAX al archivo PHP correspondiente
        $.ajax({
            type: "POST", // Método de envío.
            url: "../Modelo/AltaAlumno.php", //URL Destino.
            data: formData, // Datos del formulario serializados
            dataType: "json",  // Tipo de datos esperados del servidor
            success: function (response) {
                console.log("insertAlumno", response);
                // Si el servidor devuelve un mensaje de éxito, muestra una alerta y limpia el formulario
                if (response.message) {
                    alert(response.message);  // Muestra el mensaje de éxito
                    limpiarForm();  // Limpiar el formulario después del alta
                } else if (response.error) {
                    alert("Error: " + response.error);  // Muestra el error si lo hay
                }
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener los datos del usuario:', xhr.responseText);
                alert("Error: " + xhr.responseText);// Muestra el mensaje de error si falla la solicitud AJAX
            }
        });
    });
});

// Función para limpiar los campos del formulario después de registrar un usuario
function limpiarForm() {
    $('#nombre').val(''); // Limpia el campo nombre
    $('#apellido').val(''); // Limpia el campo apellido
    $('#dni').val(''); // Limpia el campo DNI
    //$('#deuda').val('');
    $('#mail').val(''); // Limpia el campo de correo
    $('#fechaalta').val(''); // Limpia el campo de fecha de alta
}
