$(document).ready(function () {
            // Obtener los datos guardados en localStorage
            var dni = localStorage.getItem('dni');
            var fechaInicio = localStorage.getItem('fechaInicio');
            var fechaFin = localStorage.getItem('fechaFin');

            // Si existen los datos, hacer la consulta
            if (dni && fechaInicio && fechaFin) {
                $.ajax({
                    type: "POST",
                    url: "../Modelo/movimientosUsuario.php",
                    data: { dni: dni, fechaInicio: fechaInicio, fechaFin: fechaFin },
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        if (data.length === 0) {
                            alert("No se encontraron datos para los parámetros proporcionados.");
                        } else {
                            mostrarDatos(data);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la petición AJAX:", status, error);
                        alert("Ocurrió un error al realizar la consulta.");
                    }
                });
            } else {
                alert("Faltan datos para la búsqueda.");
            }
        });

    function mostrarDatos(datos) {
    const tbody = document.querySelector("#tablaMovimientos tbody");
    tbody.innerHTML = ''; // Limpiar el contenido previo

    if (datos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6">No se encontraron movimientos.</td></tr>';
        return;
    }

    datos.forEach(movimiento => {
        // Verificar que valorabonado sea un número antes de usar toFixed
        const valorabonado = (typeof movimiento.valorabonado === 'number') ? movimiento.valorabonado.toFixed(2) : '0.00';
         const metodopago = movimiento.metodopago || 'No definido';
        const fila = document.createElement('tr');
        fila.innerHTML = `
           
            <td>${movimiento.nombre}</td>
            <td>${movimiento.apellido}</td>
            <td>$${movimiento.valorabonado}</td>
            <td>${movimiento.fecha}</td>
            <td>${movimiento.metodopago}</td>
        `;
        tbody.appendChild(fila);
    });
}
