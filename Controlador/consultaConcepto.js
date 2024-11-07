document.addEventListener('DOMContentLoaded', function() {
    cargarConceptos();
    
    const btnConsultar = document.getElementById('btnConsultar');
    if (btnConsultar) {
        btnConsultar.addEventListener('click', function() {
            const idConcepto = document.getElementById('conceptos').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            consultarRecaudacion(idConcepto, fechaInicio, fechaFin);
        });
    } else {
        console.error('El botón de consulta no se encuentra en el DOM');
    }
});


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

function consultarRecaudacion(idConcepto, fechaInicio, fechaFin) {
    if (idConcepto && fechaInicio && fechaFin) {
        // Modifica la URL para incluir fechaInicio y fechaFin
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

function limpiarTabla() {
    document.querySelector('#recaudacionTabla tbody').innerHTML = '';
}
