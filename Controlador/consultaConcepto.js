// Se ejecuta cuando el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Llama a la función para cargar los conceptos al iniciar la página
    cargarConceptos();
    
    // Obtiene el botón de consulta por su id
    const btnConsultar = document.getElementById('btnConsultar');

    // Verifica si el botón existe en el DOM antes de añadirle un event listener
    if (btnConsultar) {

        // Añade un evento click al botón de consulta
        btnConsultar.addEventListener('click', function() {
             // Obtiene los valores seleccionados de los campos de formulario
            const idConcepto = document.getElementById('conceptos').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;

            // Llama a la función para consultar la recaudación con los parámetros seleccionados
            consultarRecaudacion(idConcepto, fechaInicio, fechaFin);
        });
    } else {
         // Si no se encuentra el botón en el DOM, muestra un error en la consola
        console.error('El botón de consulta no se encuentra en el DOM');
    }
});

// Función para cargar los conceptos en el select
function cargarConceptos() {
    // Realiza una solicitud fetch para obtener los conceptos desde el servidor
    fetch('../Modelo/lista_de_conceptos.php')
        .then(response => response.text())  // Espera una respuesta en formato texto
        .then(data => {
            // Verifica si los datos contienen opciones (<option>) y las agrega al select
            if (data.includes('<option')) {
                document.getElementById('conceptos').innerHTML += data;
            } else {
                  // Si no se cargan los conceptos correctamente, muestra un error
                console.error('Error al cargar los conceptos:', data);
                alert('No se pudieron cargar los conceptos. Verifique su sesión.');
            }
        })
        .catch(error => console.error('Error en la conexión:', error)); // Si ocurre un error durante la solicitud fetch, se muestra en la consola
}

// Función para consultar la recaudación de un concepto dentro de un rango de fechas
function consultarRecaudacion(idConcepto, fechaInicio, fechaFin) {
    // Verifica que se hayan seleccionado los parámetros necesarios
    if (idConcepto && fechaInicio && fechaFin) {
        // Modifica la URL para incluir fechaInicio y fechaFin
        fetch(`../Modelo/consultar_recaudacion_concepto.php?idconcepto=${idConcepto}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`)
            .then(response => response.json())  // Espera una respuesta en formato JSON
            .then(data => {
                // Si la respuesta contiene un error, lo muestra en consola y limpia la tabla
                if (data.error) {
                    console.error('Error en la consulta:', data.error);
                    alert('Error: ' + data.error);
                    limpiarTabla();
                    return;
                }
                // Si la consulta es exitosa, actualiza la tabla con los datos
                actualizarTabla(data.data);
            })
            .catch(error => console.error('Error en la conexión:', error)); // Si ocurre un error durante la solicitud fetch, lo muestra en consola
    } else {
        // Si no se han seleccionado un concepto o un rango de fechas, muestra un mensaje de alerta
        alert('Por favor, selecciona un concepto y un rango de fechas.');
        limpiarTabla(); // Limpia la tabla si no se han seleccionado datos
    }
}

// Función para actualizar la tabla con los datos de la recaudación
function actualizarTabla(datos) {
     // Obtiene el cuerpo de la tabla donde se mostrarán los datos
    const tbody = document.querySelector('#recaudacionTabla tbody');
     // Limpia el contenido de la tabla antes de agregar los nuevos datos
    tbody.innerHTML = '';
    
    // Si no hay datos, muestra un mensaje indicando que no hay información disponible
    if (datos.length === 0) {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 2; // Hace que la celda ocupe dos columnas
        td.textContent = 'No hay datos disponibles para el concepto seleccionado.';
        td.classList.add('text-center'); // Centra el texto en la celda
        tr.appendChild(td);
        tbody.appendChild(tr);
        return;
    }
    // Si hay datos, crea una fila por cada ítem de datos y las agrega a la tabla 
    datos.forEach(item => {
        const tr = document.createElement('tr');
         // Utiliza innerHTML para agregar las celdas de la fila
        tr.innerHTML = `
            <td>${item.idconcepto}</td>
            <td>$${parseFloat(item.total_recaudado).toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}</td>`; // Muestra el total recaudado formateado en pesos
        tbody.appendChild(tr);  // Añade la fila a la tabla
    });
}

// Función para limpiar la tabla (cuando no hay datos o se desea resetear la tabla)
function limpiarTabla() {
    // Elimina todo el contenido del cuerpo de la tabla
    document.querySelector('#recaudacionTabla tbody').innerHTML = '';
}
