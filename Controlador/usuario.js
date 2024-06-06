
var x = $(document);

x.ready(iniciar);/*ready es una funcion del jQuery permite la activacion del codigo  javaScript*/

function iniciar()/*funcion para darle arranque al formulario*/
{
    getTipoUsuario();/*llamamos a la funciones*/
  
        
    
    
    
   
    $('#darAlta').on('click',saveNewUser);
    //$('#getUser').on('click',saveNewUser);
    $('#update').on('click',updateUsuario);
    //$('#deleteProduct').on('click',deleteProduct);
}



function getTipoUsuario()
{
    $.ajax
    ({
        type : 'POST',/*El tipo de peticion va a ser post*/
        url  : '../Modelo/getUsuario.php',/* peticion al archivo getUsuario.php que esta en la carpeta modelo */
        dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
        success : function(data)
        {/*Guardamos los datos a la tabla que se va a ver por pantalla*/
            let options = "";

            for(let i = 0; i < data.length; i++)
            {
                let Id_tipoUsuario  = data[i].Id_tipoUsuario;
                let Tipo_usuario   = data[i].Tipo_usuario;
                

                options += "<option value = '"+Id_tipoUsuario+"'>"+Tipo_usuario+"</option>";
            }
            $('#tipoUsuario').html(options);
            // Escucha el evento "change" y selecciona la opción
            $('#tipoUsuario').on('change', function () {
                var selectedValue = $(this).val();
                console.log("Valor seleccionado:", selectedValue);
            });
        }
    })
}
function updateUsuario()/*funcion que va a modificar los datos que
 contiene actualmente la tabla*/
{
    let formulario = $('#formulario').serialize();
    //let id = $('[name = categoriaid]:checked').val();

    //formulario += "&id="+id;

    $.ajax({
        type : 'POST',/*El tipo de peticion va a ser post*/
        url  : '../Modelo/updateUsuario.php',/* peticion al archivo setAlumno.php que esta en la carpeta modelo */
        data : formulario,
        dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
        success : function(valor)
        {
            //getUser();
            limpiarForm();
            
        }
    })
}
function saveNewUser() {
    let data = $('#formulario').serialize();
    console.log("Respuesta del servidor:", data); // Imprime la respuesta en la consola

    data += "&function=";

    $.ajax({
        type: 'POST',
        url: '../Modelo/usuario.php',
        data: data,
        dataType: 'JSON',
        success: function (data) {
            if (data.status === 'success') {
                alert("Usuario guardado con Éxito");
            } else {
                alert("Hubo un error al guardar el usuario. Por favor, inténtalo nuevamente.");
            }
           // getUser();
            limpiarForm();
        }
    })
}

function getUser(){

    let data = 'function='+2;

   // console.log(data);
     console.log("Respuesta del servidor:", data); // Imprime la respuesta en la consola

    $.ajax({
        type: 'POST',
        url : '../Modelo/usuario.php',
        data:data,
        dataType:'JSON',
        success : function(data){

            let tabla = "<tr><th>Usuario</th><th>Dni</th><th>contrasenia</th><th></th></tr>";

            console.log(data);
            for(let i = 0; i < data.length; i++)
            {
                let usuario          = data[i].usuario;
                let contrasenia    = data[i].contrasenia;
                let dni      = data[i].dni;
                
                tabla += "<tr>"+
                               "<td id='usuario"+id+"'    value = "+usuario+">"+usuario+"</td>"+
                               "<td id='contrasenia"+id+"'    value = "+contrasenia+">"+contrasenia+"</td>"+
                               "<td id='dni"+id+"' value = "+dni+">"+dni+"</td>"+
                               "<td>"+"<input type = 'radio' name = 'id' value = '"+id+"'>"+"</td>"+
                          "</tr>";
            }
            $('#usuarios').html(tabla);
        }
});

}
function limpiarForm(){/*limpia el formulario*/
    $('#usuario').prop('value','');
    $('#contrasenia').prop('value','');
    $('#dni').prop('value','');
    $('#tipoUsuario').prop('value','');
    
}

