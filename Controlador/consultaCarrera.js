// Este evento se dispara cuando el DOM está completamente cargado    
document.addEventListener('DOMContentLoaded', function() {
    // Llama a la función para cargar las carreras al inicio
    fetchCarreras();

    // Añadir evento 'change' después de cargar las carreras
    document.getElementById('carreras').addEventListener('change', function() {
        var carreraSeleccionada = this.value;  // Obtiene el valor del select
        console.log('Carrera seleccionada:', carreraSeleccionada);  // Muestra el valor seleccionado en consola

        // Llama a la función para consultar la recaudación de la carrera seleccionada
        consultarRecaudacion(carreraSeleccionada);
    });
});

// Función para obtener las carreras desde el servidor
function fetchCarreras() {
    // Crea una nueva solicitud HTTP usando XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configura la solicitud GET para obtener las carreras desde un archivo PHP
    xhr.open('GET', '../Modelo/lista_de_carreras.php', true);

    // Define lo que sucede cuando la solicitud se completa con éxito
    xhr.onload = function() {
        if (this.status === 200) {
            // Si la respuesta contiene un <option>, se asume que son datos de carrera válidos
            if (this.responseText.includes('<option')) {

                var opciones = '<option value="" disabled selected>Seleccione carrera</option>';

                // Concatenar las opciones recibidas con la opción predeterminada
                opciones += this.responseText;

                 // Agrega el contenido de la respuesta al elemento select con id 'carreras'
                document.getElementById('carreras').innerHTML = opciones;
            } else {
                // Si la respuesta no es válida, se muestra un mensaje de error
                console.error('Error al cargar las carreras:', this.responseText);
                alert('No se pudieron cargar las carreras. Por favor, verifica tu sesión.');
            }
        } else {
            // Si la solicitud falla (por ejemplo, problemas con el servidor), se muestra un mensaje de error
            console.error('Error en la solicitud AJAX:', this.status);
        }
    };

    // Manejo de errores de conexión (por ejemplo, si no se puede acceder al servidor)
    xhr.onerror = function() {
        console.error('Error en la conexión AJAX.');
    };

    // Envía la solicitud
    xhr.send();
}

// Función para consultar la recaudación de una carrera seleccionada
function consultarRecaudacion(carreraSeleccionada) {
    // Si se ha seleccionado una carrera, realiza la consulta AJAX
    if (carreraSeleccionada) {
        var xhr = new XMLHttpRequest();
        // Envía una solicitud GET con el ID de la carrera seleccionada
        xhr.open('GET', '../Modelo/consultar_recaudacion_carrera.php?idcarrera=' + carreraSeleccionada, true);
        
        // Define lo que ocurre cuando la solicitud se completa con éxito
        xhr.onload = function() {
            if (this.status === 200) {
                try {
                    // Intenta parsear la respuesta JSON
                    var respuesta = JSON.parse(this.responseText);

                    // Si la respuesta contiene un error, muestra el error
                    if (respuesta.error) {
                        console.error('Error en la respuesta PHP:', respuesta.error);
                        alert('Error al obtener los datos: ' + respuesta.error);
                        limpiarTabla(); // Limpia la tabla si ocurre un error
                        return;
                    }

                    // Mostrar el total recaudado
                    if (respuesta.total) {
                        document.getElementById('totalRecaudado').textContent = 'Total recaudado: $' + parseFloat(respuesta.total).toLocaleString('es-AR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                         // Hacer visible el total recaudado
                        document.getElementById('totalRecaudado').classList.remove('d-none');
                    }

                    // Guardar el detalle en memoria para el CSV
                    window.detalleCSV = respuesta.detalles || [];
                    
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.error('Respuesta recibida:', this.responseText);
                }
            }
        };

        xhr.onerror = function() {
            console.error('Error en la conexión AJAX.');
        };

        xhr.send();
    }
}

// Función para actualizar la tabla con los datos de la recaudación detallada
function actualizarTabla(data) {
    var tbody = document.querySelector('#recaudacionTabla tbody');
    tbody.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos

    // Si no hay datos, muestra un mensaje indicando que no hay recaudación disponible
    if (data.length === 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.setAttribute('colspan', '5'); // Hace que la celda ocupe 5 columnas
        td.classList.add('text-center'); // Centra el texto en la celda
        td.textContent = 'No hay datos disponibles para la carrera seleccionada.';
        tr.appendChild(td);
        tbody.appendChild(tr);
        return;
    }

    // Si hay datos, crea una fila para cada registro individual
    data.forEach(function(item) {
        var tr = document.createElement('tr');
        var tdCarrera = document.createElement('td');
        tdCarrera.textContent = item.carrera || 'N/A';
        tr.appendChild(tdCarrera);

        var tdAlumno = document.createElement('td');
        tdAlumno.textContent = item.alumno || 'N/A';
        tr.appendChild(tdAlumno);

        var tdConcepto = document.createElement('td');
        tdConcepto.textContent = item.concepto || 'N/A';
        tr.appendChild(tdConcepto);

        var tdValorAbonado = document.createElement('td');
        tdValorAbonado.textContent = '$' + parseFloat(item.valorabonado).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        tr.appendChild(tdValorAbonado);

        var tdFecha = document.createElement('td');
        tdFecha.textContent = item.fecha || 'N/A';
        tr.appendChild(tdFecha);

        tbody.appendChild(tr);
    });
}

// Función para limpiar la tabla (cuando no hay datos o se selecciona una carrera sin datos)
function limpiarTabla() {
    var tbody = document.querySelector('#recaudacionTabla tbody');
    tbody.innerHTML = ''; // Elimina todo el contenido de la tabla
}

// Función para convertir el detalle a formato CSV
function convertirATablaCSV() {
    if (!window.detalleCSV || window.detalleCSV.length === 0) {
        alert('No hay detalles disponibles para descargar.');
        return '';
    }

    var csvContenido = 'Carrera,Nombre,Concepto,Valor Abonado,Fecha\n';

    window.detalleCSV.forEach(function(item) {
        var filaCSV = [
            '"' + (item.carrera || 'N/A') + '"',
            '"' + (item.alumno || 'N/A') + '"',
            '"' + (item.concepto || 'N/A') + '"',
            '"' + parseFloat(item.valorabonado).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '"',
            '"' + (item.fecha || 'N/A') + '"'
        ];

        csvContenido += filaCSV.join(',') + '\n';
    });

    return csvContenido;
}

// Función para descargar el archivo CSV
function descargarCSV() {
    var csv = convertirATablaCSV();
    if (!csv) return; // No proceder si el contenido está vacío

    var enlace = document.createElement('a');
    enlace.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    enlace.target = '_blank';
    enlace.download = 'detalle_recaudacion.csv';
    enlace.click();
}

// Evento para el botón de descarga del CSV
document.getElementById('descargarCSV').addEventListener('click', function() {
    descargarCSV();
});
