var x = $(document);

x.ready(iniciar); 
// ready es una función de jQuery que asegura que el código se ejecute cuando el DOM esté listo

function iniciar() {
    $('#darAlta').on('click', saveNewConcept);
    $('#eliminar').on('click', limpiarForm);
    
}

function saveNewConcept() {
    // Recoger datos del formulario
    let concepto = $('#concepto').val().trim();
    let valor = $('#valor').val().trim();
    let anio = $('#anio').val().trim();
    
    // Verifica si algún campo requerido está vacío
    if (concepto === '' || valor === '' || anio === '') {
        alert('Por favor, completa todos los campos obligatorios.');
        return; // Detén el envío si algún campo está vacío
    }

    // Serializa los datos del formulario
    let data = $('#formulario').serialize();
    // Añade la función al conjunto de datos
    data += "&function=saveNewConcept";

    // Enviar datos al servidor usando AJAX
    $.ajax({
        type: 'POST',
        url: '../Modelo/altaConcepto.php',
        data: data,
        dataType: 'JSON',
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            alert("Concepto dado de alta correctamente.");
            limpiarForm(); // Limpia el formulario después de un envío exitoso
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
            alert("Hubo un error al procesar la solicitud.");
        }
    });
}

function limpiarForm() {
    // Limpia los campos del formulario
    $('#concepto').val('');
    $('#valor').val('');
    $('#anio').val('');
}
