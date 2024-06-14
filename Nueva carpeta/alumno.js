$(document).ready(function() {
    iniciar();
});

function iniciar() {
    $('#getDatosAlumnos').on('click', getAlumno);


}

function getAlumno() {
    let dniIngresado = $('#dni').val(); // Obtener el DNI ingresado
    $.ajax({
        type: 'POST',
        url: '../Modelo/getAlumno.php',
        data: { dni: dniIngresado }, // Enviar el DNI como parámetro
        dataType: 'json',
        success: function(data) {
            let tabla = "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Deuda</th></tr>";
            for (let i = 0; i < data.length; i++) {
                let id = data[i].id_alumno;
                let nombre = data[i].nombre;
                let apellido = data[i].apellido;
                let dni = data[i].dni;
                let deuda = data[i].deuda;

                tabla += "<tr>" +
                         "<td>" + id + "</td>" +
                         "<td id='nombre" + id + "' value='" + nombre + "'>" + nombre + "</td>" +
                         "<td id='apellido" + id + "' value='" + apellido + "'>" + apellido + "</td>" +
                         "<td id='dni" + id + "' value='" + dni + "'>" + dni + "</td>" +
                         "<td id='deuda" + id + "' value='" + deuda + "'>" + deuda + "</td>" +
                         "<td><input type='radio' name='clientid' value='" + id + "'></td>" +
                         "</tr>";
            }
            $('#alumno').html(tabla);
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX: ", status, error);
        }
    });
}
