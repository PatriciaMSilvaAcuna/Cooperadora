$(document).ready(function() {
    // Cargar conceptos al iniciar
    cargarConceptos();
    
    // Manejar clic en botón consultar
    $('#btnConsultar').on('click', function() {
        const idConcepto = $('#conceptos').val();
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();

        // Validar que todos los campos estén completos
        if (!idConcepto || !fechaInicio || !fechaFin) {
            alert('Por favor, complete todos los campos antes de consultar.');
            return;
        }

        // Validar que la fecha de inicio no sea mayor que la fecha fin
        if (fechaInicio > fechaFin) {
            alert('La fecha de inicio no puede ser posterior a la fecha fin.');
            return;
        }

        consultarRecaudacion(idConcepto, fechaInicio, fechaFin);
    });

    // Manejar clic en botón descargar Excel
    $('#btnDescargarExcel').on('click', function() {
        const idConcepto = $('#conceptos').val();
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();

        if (!idConcepto || !fechaInicio || !fechaFin) {
            alert('Por favor, complete todos los campos antes de descargar.');
            return;
        }

        const url = `../Modelo/exportar_a_excel.php?idconcepto=${idConcepto}&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;
        window.location.href = url;
    });
});

function cargarConceptos() {
    $.ajax({
        url: '../Modelo/lista_de_conceptos.php',
        type: 'GET',
        success: function(response) {
            $('#conceptos').append(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar conceptos:', error);
            alert('Error al cargar los conceptos. Por favor, intente nuevamente.');
        }
    });
}

function consultarRecaudacion(idConcepto, fechaInicio, fechaFin) {
    $.ajax({
        url: '../Modelo/consultar_recaudacion_concepto.php',
        type: 'GET',
        data: {
            idconcepto: idConcepto,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin
        },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert('Error: ' + response.error);
                limpiarTabla();
                return;
            }
            actualizarTabla(response.data);
        },
        error: function(xhr, status, error) {
            console.error('Error en la consulta:', error);
            alert('Error al realizar la consulta. Por favor, intente nuevamente.');
            limpiarTabla();
        }
    });
}

function actualizarTabla(datos) {
    const tbody = $('#recaudacionTabla tbody');
    tbody.empty();
    
    if (!datos || datos.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="2" class="text-center">No hay datos disponibles para el concepto seleccionado.</td>
            </tr>
        `);
        return;
    }

    datos.forEach(function(item) {
        tbody.append(`
            <tr>
                <td>${item.idconcepto}</td>
                <td>$${parseFloat(item.total_recaudado).toLocaleString('es-AR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</td>
            </tr>
        `);
    });
}

function limpiarTabla() {
    $('#recaudacionTabla tbody').empty();
}
