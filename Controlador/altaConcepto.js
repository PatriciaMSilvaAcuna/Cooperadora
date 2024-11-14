// Se utiliza jQuery para capturar el documento (DOM)
var x = $(document);

x.ready(iniciar); 
// ready es una función de jQuery que asegura que el código se ejecute cuando el DOM esté listo


// Funcion de Inicializacion.
function iniciar() {
    // Asigna el evento click al botón 'darAlta' para ejecutar la función saveNewConcept
    $('#darAlta').on('click', saveNewConcept);
    // Asigna el evento click al botón 'eliminar' para limpiar el formulario
    $('#eliminar').on('click', limpiarForm);
    
}

// Función para guardar un nuevo concepto.
function saveNewConcept() {
    // Recoger y limpiar los valores de los campos del formulario
    let concepto = $('#concepto').val().trim();
    let valor = $('#valor').val().trim();
    let anio = $('#anio').val().trim();
    
    // Verifica si algún campo requerido está vacío
    if (concepto === '' || valor === '' || anio === '') {
        alert('Por favor, completa todos los campos obligatorios.');
        return; // Detiene el envío si algún campo está vacío
    }

    // Valida el formato de "concepto" (solo letras y espacios)
    const conceptoRegex = /^[a-zA-Z\s]+$/;
    if (!conceptoRegex.test(concepto)) {
        alert('El concepto solo debe contener letras y espacios.');
        return;
    }

    // Valida el formato de "valor" (debe ser un número positivo)
    const valorNum = parseFloat(valor);
    if (isNaN(valorNum) || valorNum <= 0) {
        alert('El valor debe ser un número positivo.');
        return;
    }

    // Valida el formato de "año" (debe ser un número en el rango 1900 - año actual)
    const currentYear = new Date().getFullYear();// Obtiene el año actual.
    const anioNum = parseInt(anio);
    if (isNaN(anioNum) || anioNum < 2000 || anioNum > currentYear) {
        alert('El año debe ser un número entre 2000 y el año actual.');
        return;
    }

    // Serializa los datos del formulario
    let data = $('#formulario').serialize();
    // Añade la función al conjunto de datos
    data += "&function=saveNewConcept";

    // Enviar datos al servidor usando AJAX
    $.ajax({
        type: 'POST',// Método de envío (POST)
        url: '../Modelo/altaConcepto.php',// Archivo PHP que procesará los datos
        data: data,// Datos serializados del formulario
        dataType: 'JSON', // Tipo de datos esperados en la respuesta
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            alert("Concepto dado de alta correctamente.");
            limpiarForm(); // Limpia el formulario después de un envío exitoso
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);// Muestra el error en la consola si ocurre
            alert("Hubo un error al procesar la solicitud.");
        }
    });
}

// Función para limpiar los campos del formulario
function limpiarForm() {
    // Resetea los valores de los campos del formulario a vacío
    $('#concepto').val('');
    $('#valor').val('');
    $('#anio').val('');
}
