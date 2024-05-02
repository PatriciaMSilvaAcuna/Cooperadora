function updateUsuario()/*funcion que va a modificar los datos que
 contiene actualmente la tabla*/
{
    let formulario = $('#formulario').serialize();
    let id = $('[name = categoriaid]:checked').val();

    formulario += "&id="+id;

    $.ajax({
        type : 'POST',/*El tipo de peticion va a ser post*/
        url  : '../Modelo/updateUsuario.php',/* peticion al archivo setAlumno.php que esta en la carpeta modelo */
        data : formulario,
        dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
        success : function(valor)
        {
            getCategoria();
            limpiarForm();
            
        }
    })
}

