document.addEventListener('DOMContentLoaded', function() {
    cargarConceptos();
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

function consultarRecaudacion(idConcepto) {
    if (idConcepto) {
        fetch(`../Modelo/consultar_recaudacion_concepto.php?idconcepto=${idConcepto}`)
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

document.getElementById('conceptos').addEventListener('change', function() {
    consultarRecaudacion(this.value);
});
