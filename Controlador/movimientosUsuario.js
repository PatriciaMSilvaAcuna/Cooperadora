// Se ejecuta cuando el DOM está completamente cargado
$(document).ready(function () {
     // Evento que se dispara cuando se hace clic en el botón con id 'consultaDni'
    $("#consultaDni").click(function (event) { 
        // Prevenir el comportamiento por defecto del formulario (evitar que se recargue la página)
        event.preventDefault();
        
        // Obtengo los valores introducidos en los campos del formulario
        var dni = $("#dniInput").val(); // Valor del campo de DNI
        var fechaInicio = $("#fechaInicioInput").val(); // Valor del campo de fecha de inicio
        var fechaFin = $("#fechaFinInput").val(); // Valor del campo fecha fin

        // Verifico que los tres campos estén completos
        if (dni && fechaInicio && fechaFin) {
            // Si todos los campos están completos, los guardo en localStorage
            localStorage.setItem('dni', dni); // Guarda el DNI ingresado
            localStorage.setItem('fechaInicio', fechaInicio); // Guarda la fecha inicio ingresada
            localStorage.setItem('fechaFin', fechaFin); // Guarda la fecha fin ingresada
            
             // Redirige al usuario a la página de resultados de movimientos
            window.location.href = "resultadosMovimientos.html";
        } else {
            // Si alguno de los campos está vacío, muestra una alerta pidiendo que los complete
            alert("Por favor, ingrese todos los campos.");
        }
    });
});

