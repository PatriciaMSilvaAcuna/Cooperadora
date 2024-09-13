$(document).ready(function () {
    $("#consultaDni").click(function (event) { 
        event.preventDefault();
        
        // Obtengo los valores del formulario
        var dni = $("#dniInput").val();
        var fechaInicio = $("#fechaInicioInput").val();
        var fechaFin = $("#fechaFinInput").val();

        if (dni && fechaInicio && fechaFin) {
            // Guardar los datos en localStorage
            localStorage.setItem('dni', dni);
            localStorage.setItem('fechaInicio', fechaInicio);
            localStorage.setItem('fechaFin', fechaFin);
            
            // Redirigir a la página de resultados
            window.location.href = "resultadosMovimientos.html";
        } else {
            alert("Por favor, ingrese todos los campos.");
        }
    });
});
