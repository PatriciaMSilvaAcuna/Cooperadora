var x = $(document);

x.ready(iniciar);/*ready es una funcion del jQuery permite la activacion del codigo  javaScript*/
//let userId;
function iniciar()/*funcion para darle arranque al formulario*/
{

   $('#darAlta').on('click',saveNewConcept);
   $('#eliminar').on('click',limpiarForm);
   $('#btnDarDeBaja').on('click',bajaConcepto);
}

function saveNewConcept(){
 // Verifica si algún campo requerido está vacío
    let concepto = $('#usuario').val().trim();
    let valor = $('#contrasenia').val().trim();
    
 // Verifica si algún campo requerido está vacío
    if (concepto === '' || valor === '') {
        alert('Por favor, completa todos los campos obligatorios.');
        return; // Detén el envío si algún campo está vacío
    }
 
}

    let data = $('#formulario').serialize();
    console.log("Respuesta del servidor:", data); // Imprime la respuesta en la consola

    data += "&function=+1";

    $.ajax({
        type: 'POST',
        url: '../Modelo/concepto.php',
        data: data,
        dataType: 'JSON',
        success: function(response) {
          console.log("saveNewConcept",response);
          alert("Concepto dado de alta");
         
         limpiarForm();
        }
    })

function limpiarForm(){/*limpia el formulario*/
    console.log("Limpieza de form");
    $('#concepto').prop('value','');
    $('#valor').prop('value','');
    
   
}







