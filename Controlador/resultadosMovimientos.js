 // Función que genera y descarga el archivo CSV
 function downloadCSV() {
           
            // Función para convertir una tabla HTML a CSV
            function tableToCSV(tableId) {
                var csv = [];
                var rows = document.querySelectorAll(tableId + ' tr');
                
                // Recorremos las filas de la tabla
                rows.forEach(function(row) {
                    var cols = row.querySelectorAll('td, th');
                    var rowData = [];
                    cols.forEach(function(col) {
                        rowData.push(col.innerText.trim()); // Tomamos el texto dentro de las celdas
                    });
                    csv.push(rowData.join(',')); // Unimos los datos de la fila por coma
                });
                
                return csv.join('\n'); // Unimos las filas por salto de línea
            }
            
            // Convertimos las tres tablas a CSV
            var csvUsuario = tableToCSV('#tablaUsuario');
            var csvAlumno = tableToCSV('#tablaAlumno');
            var csvPagos = tableToCSV('#tablaPagos');
            
            // Concatenamos los CSV de las tablas
            var csvContent = "Datos del Usuario\n" + csvUsuario + "\n\nAltas de Alumnos\n" + csvAlumno + "\n\nPagos Realizados\n" + csvPagos;
            
            // Creamos un archivo CSV y lo descargamos
            var encodedUri = encodeURI('data:text/csv;charset=utf-8,' + csvContent);
            var link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'movimientos_usuario.csv');
            link.click();
}
// Se ejecuta cuando el DOM está completamente cargado
$(document).ready(function () {
    // Recupero los valores almacenados en localStorage
    var dni = localStorage.getItem('dni');
    var fechaInicio = localStorage.getItem('fechaInicio');
    var fechaFin = localStorage.getItem('fechaFin');

    // Muestra los valores recuperados en la consola para verificar
    console.log("DNI:", dni);
    console.log("Fecha Inicio:", fechaInicio);
    console.log("Fecha Fin:", fechaFin);

    // Verifico si los tres valores necesarios están disponibles en localStorage
    if (dni && fechaInicio && fechaFin) {
        // Si los valores están disponibles, realizo una solicitud AJAX para obtener los datos
        $.ajax({
            type: "POST", // Método de solicitud POST
            url: "../Modelo/movimientosUsuario.php",  // URL del script PHP que procesará la solicitud
            data: { dni: dni, fechaInicio: fechaInicio, fechaFin: fechaFin }, // Datos que se enviarán al servidor
            dataType: "json", // Indico que espero una respuesta en formato JSON
            success: function (data) {
                 // Si la solicitud es exitosa, se muestra la respuesta en la consola
                console.log("Datos recibidos:", data);
                // Si la respuesta contiene un error, lo muestro en un mensaje de alerta
                if (data.error) {
                    alert(data.error);
                } else {
                    // Si no hay error, muestro los datos del usuario, alumno y pagos
                    console.log("Datos de usuario:", data.usuario);
                    console.log("Datos de alumno:", data.alumno);
                    console.log("Datos de pagos:", data.pagos);
                    // Llamo a la función para mostrar los datos en la interfaz
                    mostrarDatos(data);
                }
            },
            error: function (xhr, status, error) {
                // Si ocurre un error en la solicitud AJAX, lo registro en la consola y muestro un mensaje de alerta
                console.error("Error en la petición AJAX:", status, error);
                console.log("Respuesta del servidor:", xhr.responseText);
                // Si falta alguno de los datos necesarios, muestro una alerta indicando que faltan datos
                alert("Ocurrió un error al realizar la consulta.");
            }
        });
    } else {
        alert("Faltan datos para la búsqueda.");
    }
});

// Función para mostrar los datos en las tablas correspondientes
function mostrarDatos(datos) {
    // Obtengo las tablas donde se mostrarán los datos
    const tablaUsuario = document.querySelector("#tablaUsuario tbody");
    const tablaAlumno = document.querySelector("#tablaAlumno tbody");
    const tablaPagos = document.querySelector("#tablaPagos tbody");

    // Muestra los datos recibidos en la consola para verificar
    console.log("Datos recibidos:", datos);

     // Verifico si existe la tabla de usuario
    if (tablaUsuario) {
        // Limpio la tabla antes de agregar los nuevos datos
        tablaUsuario.innerHTML = '';

         // Verifico si hay datos para la tabla de usuario y si están en formato de array
        if (datos.usuario && Array.isArray(datos.usuario) && datos.usuario.length > 0) {
            // Itero sobre los datos del usuario para crear una fila en la tabla por cada uno
            datos.usuario.forEach(usuario => {
                // Determino si el usuario está activo o inactivo
                const estadoUsuario = usuario.usuarioactivo === 1 ? 'ACTIVO' : 'INACTIVO';
                
                // Creo una nueva fila para la tabla de usuarios
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${usuario.idusuario || 'No disponible'}</td>
                    <td>${usuario.mailusuario || 'No disponible'}</td>
                    <td>${usuario.dniusuario || 'No disponible'}</td>
                    <td>${usuario.tipousuario || 'No disponible'}</td>
                    <td>${estadoUsuario || 'No disponible'}</td>
                `;
                // Agrego la fila a la tabla de usuarios
                tablaUsuario.appendChild(fila);
            });
        } else {
            // Si no hay datos de usuario, muestro un mensaje en la tabla
            tablaUsuario.innerHTML = '<tr><td colspan="5">No se encontraron datos de usuario.</td></tr>';
        }
    }
     // Verifico si existe la tabla de alumno
    if (tablaAlumno) {
         // Limpio la tabla antes de agregar los nuevos datos
        tablaAlumno.innerHTML = '';
        // Verifico si hay datos para la tabla de alumno y si están en formato de array
        if (datos.alumno && Array.isArray(datos.alumno) && datos.alumno.length > 0) {
            // Itero sobre los datos del alumno para crear una fila en la tabla por cada uno
            datos.alumno.forEach(alumno => {
                 // Creo una nueva fila para la tabla de alumnos
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${alumno.idalumno || 'No disponible'}</td>
                    <td>${alumno.nombre || 'No disponible'}</td>
                    <td>${alumno.apellido || 'No disponible'}</td>
                    <td>${alumno.mail || 'No disponible'}</td>
                    <td>${alumno.deuda || 'No disponible'}</td>
                    <td>${alumno.fechaalta || 'No disponible'}</td>
                `;
                // Agrego la fila a la tabla de alumnos
                tablaAlumno.appendChild(fila);
            });
        } else {
            // Si no hay datos de alumno, muestro un mensaje en la tabla
            tablaAlumno.innerHTML = '<tr><td colspan="6">No se encontraron datos de alumno.</td></tr>';
        }
    }
    // Verifico si existe la tabla de pagos
    if (tablaPagos) {
        // Limpio la tabla antes de agregar los nuevos datos
        tablaPagos.innerHTML = '';
        // Verifico si hay datos para la tabla de pagos y si están en formato de array
        if (datos.pagos && Array.isArray(datos.pagos) && datos.pagos.length > 0) {
            // Itero sobre los datos de pagos para crear una fila en la tabla por cada uno
            datos.pagos.forEach(pago => {
                // Formateo el valor abonado a dos decimales
                const valorabonado = (typeof pago.valorabonado === 'number') ? pago.valorabonado.toFixed(2) : '0.00';
                
                 // Creo una nueva fila para la tabla de pagos
                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${pago.idcargapago || 'No disponible'}</td>
                    <td>${pago.fecha || 'No disponible'}</td>
                    <td>$${valorabonado || '0.00'}</td>
                    <td>${pago.metodo_pago || 'No disponible'}</td>   <!-- Cambiado para usar metodo_pago -->
                    <td>${pago.concepto || 'No disponible'}</td>     <!-- Cambiado para usar concepto -->
                `;
                 // Agrego la fila a la tabla de pagos
                tablaPagos.appendChild(fila);
            });
        } else {
             // Si no hay datos de pagos, muestro un mensaje en la tabla
            tablaPagos.innerHTML = '<tr><td colspan="5">No se encontraron registros de pagos.</td></tr>';
        }
    }
}
