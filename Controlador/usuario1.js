
$(document).ready(function() {

    iniciar();//se llama a la función iniciar cuando el documento se encuentra OK
    function iniciar (){
            $('#buscarUsuario').on('click', function(event){
                event.preventDefault(); // Previene la recarga de la página
                buscarDatosUsuario();
            })
                $('#actualizarForm').on('submit', function(event) {
                event.preventDefault(); // Evita la recarga de la página
        
                actualizarUsuario(); // Llama a la función para actualizar el usuario
            });
        }


function buscarDatosUsuario(){
    let Dni_usuario = $('#Dni_usuario1').val();
    console.log('DNI del usuario ingresado:', Dni_usuario); // Verifica el DNI ingresado
    
    if (Dni_usuario === '') {
        alert('Por favor, complete el campo DNI');
        return; // Detén el envío si algún campo está vacío
    }
    else  { 
            $.ajax ({
                type : 'POST',/*El tipo de peticion va a ser post*/
                data: { Dni_usuario: Dni_usuario }, //pasamos la informacion del DNI que se capturó del formulario
                url  : '../Modelo/buscar_usuario.php',/* peticion al archivo php que esta en la carpeta modelo */
                dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
                success : function(data){
                    console.log('Datos recibidos del servidor:', data); // Agrega esto para ver la respuesta del servidor
                    $('#Dni_usuario1').val('');
                    if (data.error) {
                        // Muestra el mensaje de error si no se encuentra el usuario
                        alert(data.error);
                    } else {
                        // Itera sobre los datos obtenidos si no hay error
                        for (let i = 0; i < data.length; i++) {
                            let idusuario = data[i].idusuario;
                            let Dni_usuario = data[i].dniusuario; // Usar el campo 'dniusuario' para el DNI del usuario
                            let contrasenia = data[i].contrasenia;
                            let mailusuario = data[i].mailusuario;
                            let usuario_activo = data[i].usuarioactivo;
                            
                            // Llamamos otra función para cargar los inputs con los datos del usuario
                            cargarInputUsuario(idusuario, Dni_usuario, contrasenia, mailusuario, usuario_activo);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos del usuario:', error);
                    alert('Error al obtener los datos del usuario.');
                }
            });
        }
    }
        
    
    
    function cargarInputUsuario(idusuario, Dni_usuario, contrasenia, mailusuario, usuario_activo) {
        // Muestra los datos que se están cargando en la consola para depuración.
        console.log('Cargando datos en el formulario:', {
            idusuario: idusuario,
            Dni_usuario: Dni_usuario,
            contrasenia: contrasenia,
            mailusuario: mailusuario,
            usuario_activo: usuario_activo
         }); // verifica los datos que se están cargando
        // Establece el valor de los campos del usuario en el formulario.
        $('#idusuario').val(idusuario);
        $('#Dni_usuario').val(Dni_usuario);
        $('#contrasenia').val(''); // Dejar el campo de contraseña vacío por seguridad
        $('#mailusuario').val(mailusuario);
        $('#usuario_activo').prop('checked', usuario_activo == 1);
        // Muestra un mensaje en el elemento con id "mensaje" indicando que los datos se han cargado correctamente.
        alert('Datos cargados correctamente.');
        
    }



    function actualizarUsuario()/*funcion para actualizar los datos de un cliente*/
{
    let formulario = $('#actualizarForm').serialize();
    let idusuario = $('#idusuario').val();
    formulario += "&idusuario=" + idusuario;
    console.log("Datos enviados: ", formulario);

    $.ajax({
        type : 'POST',/*El tipo de peticion va a ser post*/
        url  : '../Modelo/actualizar_usuario.php',/* peticion al archivo php que esta en la carpeta modelo */
        data : formulario,
        dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
        success: function(response) {
            // Maneja la respuesta del servidor
            if (response.success) {
                alert('Datos actualizados correctamente.');
            limpiarForm();
            } else {
                alert(response.message || 'Error al actualizar los datos.');
            }
        },
        error: function(xhr, status, error) {
            // Maneja errores en la petición AJAX
            console.error('Error al actualizar el usuario:',status, error);
            alert('Error al actualizar los datos. Estado: ' + status + ', Error: ' + error);
        }
    });
}

function limpiarForm() {
    $('#actualizarForm')[0].reset();
}
});
