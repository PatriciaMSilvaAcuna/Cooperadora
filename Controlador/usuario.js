
var x = $(document);

x.ready(iniciar);/*ready es una funcion del jQuery permite la activacion del codigo  javaScript*/
//let userId;
function iniciar()/*funcion para darle arranque al formulario*/
{
  
    getTipoUsuario();/*llamamos a la funciones*/
    
    $('#darAlta').on('click',saveNewUser);
    $('#getUser').on('click',getUser);
   $('#eliminar').on('click',limpiarForm);
   $('#btnDarDeBaja').on('click',bajaUsuario);
}



function getTipoUsuario()
{
    $.ajax
    ({
        type : 'POST',/*El tipo de peticion va a ser post*/
        url  : '../Modelo/getTipoUsuario.php',/* peticion al archivo getUsuario.php que esta en la carpeta modelo */
        dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
        success : function(data)
        {/*Guardamos los datos a la tabla que se va a ver por pantalla*/
            let options = "";

            for(let i = 0; i < data.length; i++)
            {
                let id_tipodeusuario  = data[i].id_tipodeusuario;
                let tipoUsuario   = data[i].tipoUsuario;
                

                options += "<option value = '"+id_tipodeusuario+"'>"+tipoUsuario+"</option>";
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

    data += "&function=+1";

    $.ajax({
        type: 'POST',
        url: '../Modelo/usuario.php',
        data: data,
        dataType: 'JSON',
        success: function(response) {
          console.log("saveNewUser",response);
          alert("Usuario dado de alta");
         // document.getElementById('mensaje').textContent = "Usuario dado de alta"; 
           // getUser();
         limpiarForm();
        }
    })
}

function getUser(){

   let data = 'function='+2;

   // console.log(data);
    console.log("Respuesta del servidor:", data); // Imprime la respuesta en la consola
let dni = $('#dni').val(); // Obtener el DNI ingresado
    if (dni) {
    $.ajax({
        type: 'POST',
        url : '../Modelo/getUsuario.php',
       data: { dni: dni },
        dataType:'JSON',
        success : function(data){

            let tabla = "<tr><th>Id_Usuario</th><th>Usuario</th><th>Contraseña</th><th>DNI</th><th>Estado</th><th>Seleccionar</th></tr>";

          //  console.log(data);
            for(let i = 0; i < data.length; i++)
            {   let id = data[i].Id_Usuario;
                let usuario= data[i].Usuario;
                let contrasenia= data[i].Contrasenia;
                let dni= data[i].Dni_Usuario;
                let estado= data[i].Usuario_activo;
                
                tabla += "<tr>"+
                            "<td>" + id + "</td>" +
                            "<td>" + usuario + "</td>" +
                            "<td>" + contrasenia + "</td>" +
                            "<td>" + dni + "</td>" +
                            "<td>" + estado + "</td>" +
                            "<td><input type='checkbox' class='user-checkbox' data-id='" + id + "'></td>" + // columna con checkbox
                            "</tr>";
                    
            }
            $('#usuario').html(tabla);
        },
        error: function(xhr, status, error) {
                    console.error('Error al obtener los datos del usuario:', error); //Mostrar mensaje de error
                }
});
}else{
        alert('Por favor ingrese un DNI');
}
 $(document).ready(function() {
    $(document).on('change', '.user-checkbox', function() {
        $('.user-checkbox').not(this).prop('checked', false);

        /*// Obtener el ID del usuario seleccionado
        const userId = $(this).data('id');
        console.log('Usuario seleccionado:', userId);
        // Llamar a la función para procesar el usuario
       procesarUsuario(userId);
*/
 });
});
}
/*// Función para procesar el ID del usuario
function procesarUsuario(userId) {
    console.log('Procesando usuario con ID:', userId);
    $.ajax({
        type: 'POST',
        url: '../Modelo/bajaUsuario.php',
        data: { userId: userId }, // Envía el ID del usuario
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta del servidor:', response);

            // Mostrar la respuesta al usuario (puedes adaptar esto según tus necesidades)
            if (response && response.message) {
                alert('Respuesta del servidor: ' + response.message);
            } else {
                alert('Respuesta inesperada del servidor.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al procesar el usuario:', error);
            console.log('Respuesta completa del servidor:', xhr.responseText);

            // Mostrar un mensaje de error al usuario
            alert('Error al procesar el usuario. Por favor, inténtalo nuevamente más tarde.');
        }
    });
}
*/
// Función para procesar la baja del usuario
function bajaUsuario(button) {
    const userId = $('.user-checkbox:checked').data('id');
    if (userId) {
        // Realizar la operación de baja con el ID del usuario
        console.log('Baja del usuario con ID:', userId);
        $.ajax({
            type: 'POST',
            url: '../Modelo/bajaUsuario.php',
            data: { userId: userId },
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                limpiarForm();
                alert("Usuario dado de baja correctamente");
                 $('#usuario').remove();
            },
            error: function(xhr, status, error) {
                console.error('Error al dar de baja al usuario:', error);
            }
        });
    } else {
        alert('Por favor, selecciona un usuario para dar de baja.');
    }
}



function limpiarForm(){/*limpia el formulario*/
    console.log("Limpieza de form");
    $('#usuario').prop('value','');
    $('#contrasenia').prop('value','');
    $('#dni').prop('value','');
   
}


