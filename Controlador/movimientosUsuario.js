$(document).ready(function () {
    $("#dni").click(function (event) {
        event.preventDefault(); // Evitar que el formulario se envíe automáticamente
        var dni = $("#dniInput").val(); // Obtener el valor del campo DNI
        obtenerMovimientos(dni); // Llamar a la función obtenerMovimientos con el DNI
    });
});

function obtenerMovimientos(dni) {
    $.ajax({
        type: "POST",
        url: "../Modelo/movimientosUsuario.php",
        data: { dni: dni }, // Enviar el DNI al servidor PHP
        dataType: "json",
        success: function (data) {
            console.log("Respuesta del servidor:", data);
            $("#alumno").empty(); // Limpiar la tabla antes de agregar nuevas filas

            // Agregar fila de cabecera
            //var cabecera = "<tr><th>Nombre</th><th>Apellido</th><th>Valor Abonado</th><th>Fecha</th><th>Método de Pago</th><th>Concepto</th></tr>";
            var cabecera = '<tr>' +
               '<th>Nombre</th>' +
               '<th>Apellido</th>' +
               '<th>Valor Abonado</th>' +
               '<th>Fecha</th>' +
               '<th>Método de Pago</th>' +
               '</tr>';
            $("#alumno").append(cabecera);

            // Agregar cada fila de datos a la tabla
            $.each(data, function (index, alumno) {
            //    var row = "<tr><td>" + alumno.nombre + "</td><td>" + alumno.apellido + "</td><td>" + alumno.valorAbonado + "</td><td>" + alumno.fecha + "</td><td>" + alumno.tipoDePago + "</td><td>" + alumno.nombreConcepto + "</td></tr>";
                var row = '<tr>' +
                    '<td>' + alumno.nombre + '</td>' +
                    '<td>' + alumno.apellido + '</td>' +
                    '<td>' + alumno.valorAbonado + '</td>' +
                    '<td>' + alumno.fecha + '</td>' +
                    '<td>' + alumno.tipoDePago + '</td>' +
                    '</tr>';
                $("#alumno").append(row); // Agregar cada fila a la tabla
            });
        },
        error: function (xhr, status, error) {
            console.error("Error en la petición AJAX:", status, error);
            console.log("Respuesta del servidor:", xhr.responseText); // Ver la respuesta del servidor en caso de error
        }
    });
}
