// Se ejecuta cuando el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Llama a la función para cargar los conceptos al iniciar la página
    cargarConceptos();
    
    // Obtiene el botón de consulta por su id
    const btnConsultar = document.getElementById('btnConsultar');

    // Verifica si el botón de consulta existe en el DOM antes de añadirle un event listener
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
        console.error('El botón de consulta no se encuentra en el DOM');
    }

    // Obtiene el botón de descarga Excel por su id
    const btnDescargarExcel = document.getElementById('btnDescargarExcel');

    // Verifica si el botón de descarga existe en el DOM antes de añadirle un event listener
    if (btnDescargarExcel) {
        // Añade un evento click al botón de descarga
        btnDescargarExcel.addEventListener('click', function() {
            // Obtiene los valores seleccionados de los campos de formulario
            const idConcepto = document.getElementById('conceptos').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;

            // Verifica que se hayan seleccionado los parámetros necesarios
            if (idConcepto && fechaInicio && fechaFin) {
                // Construye la URL para el archivo PHP con los parámetros seleccionados
                const url = `../Modelo/exportar_a_excel.php?idconcepto=${idConcepto}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;

                // Crea un enlace temporal para forzar la descarga del archivo
                const link = document.createElement('a');
                link.href = url;
                link.target = '_blank'; // Opcional: abre en una nueva pestaña
                link.download = ''; // Descarga el archivo con el nombre definido en el servidor
                document.body.appendChild(link); // Agrega el enlace al DOM
                link.click(); // Simula un clic en el enlace
                document.body.removeChild(link); // Elimina el enlace después de la descarga
            } else {
                // Si faltan parámetros, muestra una alerta
                alert('Por favor, selecciona un concepto y un rango de fechas para descargar el Excel.');
            }
        });
    } else {
        console.error('El botón de descarga Excel no se encuentra en el DOM');
    }
});

// Función para cargar los conceptos en el select
function cargarConceptos() {
    fetch('../Modelo/lista_de_conceptos.php')
        .then(response => response.text())
        .then(data => {
            if (data.includes('<option')) {
                document.getElementById('conceptos').innerHTML += data;
            } else {
                console.error('Error al cargar los conceptos:', data);
                alert('No se pudieron cargar los conceptos. Verifique su sesión.');
            }
        })
        .catch(error => console.error('Error en la conexión:', error));
}

// Función para consultar la recaudación de un concepto dentro de un rango de fechas
function consultarRecaudacion(idConcepto, fechaInicio, fechaFin) {
    if (idConcepto && fechaInicio && fechaFin) {
        fetch(`../Modelo/consultar_recaudacion_concepto.php?idconcepto=${idConcepto}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error en la consulta:', data.error);
                    alert('Error: ' + data.error);
                    limpiarTabla();
                    return;
                }
                actualizarTabla(data.data);
            })
            .catch(error => console.error('Error en la conexión:', error));
    } else {
        alert('Por favor, selecciona un concepto y un rango de fechas.');
        limpiarTabla();
    }
}

// Función para actualizar la tabla con los datos de la recaudación
function actualizarTabla(datos) {
    const tbody = document.querySelector('#recaudacionTabla tbody');
    tbody.innerHTML = '';
    if (datos.length === 0) {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 2;
        td.textContent = 'No hay datos disponibles para el concepto seleccionado.';
        td.classList.add('text-center');
        tr.appendChild(td);
        tbody.appendChild(tr);
        return;
    }
    datos.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.idconcepto}</td>
            <td>$${parseFloat(item.total_recaudado).toLocaleString('es-AR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}</td>`;
        tbody.appendChild(tr);
    });
}

// Función para limpiar la tabla
function limpiarTabla() {
    document.querySelector('#recaudacionTabla tbody').innerHTML = '';
}
