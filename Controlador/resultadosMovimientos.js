$(document).ready(function () {
    var dni = localStorage.getItem('dni');
    var fechaInicio = localStorage.getItem('fechaInicio');
    var fechaFin = localStorage.getItem('fechaFin');
    console.log("DNI:", dni);
    console.log("Fecha Inicio:", fechaInicio);
    console.log("Fecha Fin:", fechaFin);


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

    console.log("Datos recibidos:", datos);

    if (tablaUsuario) {
        tablaUsuario.innerHTML = '';
        if (datos.usuario && Array.isArray(datos.usuario) && datos.usuario.length > 0) {
            datos.usuario.forEach(usuario => {
                // Convertimos usuarioactivo en leyenda "ACTIVO" o "INACTIVO"
                const estadoUsuario = usuario.usuarioactivo === 1 ? 'ACTIVO' : 'INACTIVO';
                
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${usuario.idusuario || 'No disponible'}</td>
                    <td>${usuario.mailusuario || 'No disponible'}</td>
                    <td>${usuario.dniusuario || 'No disponible'}</td>
                    <td>${usuario.tipousuario || 'No disponible'}</td>
                    <td>${estadoUsuario || 'No disponible'}</td>
                `;
                tablaUsuario.appendChild(fila);
            });
        } else {
            tablaUsuario.innerHTML = '<tr><td colspan="5">No se encontraron datos de usuario.</td></tr>';
        }
    }

    if (tablaAlumno) {
        tablaAlumno.innerHTML = '';
        if (datos.alumno && Array.isArray(datos.alumno) && datos.alumno.length > 0) {
            datos.alumno.forEach(alumno => {
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${alumno.idalumno || 'No disponible'}</td>
                    <td>${alumno.nombre || 'No disponible'}</td>
                    <td>${alumno.apellido || 'No disponible'}</td>
                    <td>${alumno.mail || 'No disponible'}</td>
                    <td>${alumno.deuda || 'No disponible'}</td>
                    <td>${alumno.fechaalta || 'No disponible'}</td>
                `;
                tablaAlumno.appendChild(fila);
            });
        } else {
            tablaAlumno.innerHTML = '<tr><td colspan="6">No se encontraron datos de alumno.</td></tr>';
        }
    }

    if (tablaPagos) {
        tablaPagos.innerHTML = '';
        if (datos.pagos && Array.isArray(datos.pagos) && datos.pagos.length > 0) {
            datos.pagos.forEach(pago => {
                const valorabonado = (typeof pago.ValorAbonado === 'number') ? pago.ValorAbonado.toFixed(2) : '0.00';
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${pago.idcargapago || 'No disponible'}</td>
                    <td>${pago.fecha || 'No disponible'}</td>
                    <td>$${valorabonado || '0.00'}</td>
                    <td>${pago.idmetodopago || 'No disponible'}</td>
                    <td>${pago.idconcepto || 'No disponible'}</td>
                `;
                tablaPagos.appendChild(fila);
            });
        } else {
            tablaPagos.innerHTML = '<tr><td colspan="5">No se encontraron registros de pagos.</td></tr>';
        }
    }
}
