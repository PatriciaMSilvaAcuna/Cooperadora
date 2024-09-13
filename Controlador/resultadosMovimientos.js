$(document).ready(function () {
    var dni = localStorage.getItem('dni');
    var fechaInicio = localStorage.getItem('fechaInicio');
    var fechaFin = localStorage.getItem('fechaFin');

    if (dni && fechaInicio && fechaFin) {
        $.ajax({
            type: "POST",
            url: "../Modelo/movimientosUsuario.php",
            data: { dni: dni, fechaInicio: fechaInicio, fechaFin: fechaFin },
            dataType: "json",
            success: function (data) {
                console.log("Datos recibidos:", data);
                if (data.error) {
                    alert(data.error);
                } else {
                    console.log("Datos de usuario:", data.usuario);
                    console.log("Datos de alumno:", data.alumno);
                    console.log("Datos de pagos:", data.pagos);
                    mostrarDatos(data);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la petición AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                alert("Ocurrió un error al realizar la consulta.");
            }
        });
    } else {
        alert("Faltan datos para la búsqueda.");
    }
});

function mostrarDatos(datos) {
    const tablaUsuario = document.querySelector("#tablaUsuario tbody");
    const tablaAlumno = document.querySelector("#tablaAlumno tbody");
    const tablaPagos = document.querySelector("#tablaPagos tbody");

    console.log("Datos de usuario:", datos.usuario);
    console.log("Datos de alumno:", datos.alumno);
    console.log("Datos de pagos:", datos.pagos);

    if (tablaUsuario) {
        tablaUsuario.innerHTML = '';
        if (datos.usuario && datos.usuario.length > 0) {
            datos.usuario.forEach(usuario => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${usuario.idusuario}</td>
                    <td>${usuario.MailUsuario}</td>
                    <td>${usuario.DNI}</td>
                    <td>${usuario.TipoUsuario}</td>
                `;
                tablaUsuario.appendChild(fila);
            });
        } else {
            tablaUsuario.innerHTML = '<tr><td colspan="4">No se encontraron datos de usuario.</td></tr>';
        }
    }

    if (tablaAlumno) {
        tablaAlumno.innerHTML = '';
        if (datos.alumno && datos.alumno.length > 0) {
            datos.alumno.forEach(alumno => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${alumno.IDAlumno}</td>
                    <td>${alumno.NombreAlumno}</td>
                    <td>${alumno.ApellidoAlumno}</td>
                    <td>${alumno.MailAlumno}</td>
                    <td>${alumno.Deuda}</td>
                    <td>${alumno.FechaAlta}</td>
                `;
                tablaAlumno.appendChild(fila);
            });
        } else {
            tablaAlumno.innerHTML = '<tr><td colspan="6">No se encontraron datos de alumno.</td></tr>';
        }
    }

    if (tablaPagos) {
        tablaPagos.innerHTML = '';
        if (datos.pagos && datos.pagos.length > 0) {
            datos.pagos.forEach(pago => {
                const valorabonado = (typeof pago.ValorAbonado === 'number') ? pago.ValorAbonado.toFixed(2) : '0.00';
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${pago.IDPago}</td>
                    <td>${pago.FechaPago}</td>
                    <td>$${valorabonado}</td>
                    <td>${pago.MetodoPago}</td>
                    <td>${pago.Concepto}</td>
                `;
                tablaPagos.appendChild(fila);
            });
        } else {
            tablaPagos.innerHTML = '<tr><td colspan="5">No se encontraron registros de pagos.</td></tr>';
        }
    }
}
