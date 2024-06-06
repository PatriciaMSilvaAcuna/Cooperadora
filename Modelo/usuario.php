<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

$function = $_POST['function'];

if($function == 1) {echo saveNewUser();}
else if($function == 2) {echo getUser();}
else if($function == 3) {echo updateUsuario();}


function saveNewUser()/*Creamos  la funcion que va a guardar nuevos datos a la tabla*/
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/

    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];
    $dni = $_POST['dni'];
    $tipoUsuario=$_POST['tipoUsuario'];

    $query  = "INSERT INTO usuario (Usuario,Contrasenia,Dni_Usuario, Id_tipoUsuario, Usuario_activo) values('$usuario','$contrasenia',$dni,$tipoUsuario,1)";

    if(!$mysqli->query($query)){
        return json_encode("Hubo un fallo al dar de alta el usuario");
    }else{
        return json_encode("El usuario fue dado de alta correctamente");
    }

}

function getUser(){/*funcion que va a solicitar al servidor una informacion*/
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/

    $query = "SELECT p.id as id, p.Usuario as usuario, p.Contrasenia as contrasenia, p.Dni_Usuario as dni, c.id as idcategoria, c.Id_tipoUsuario as tipoUsuario FROM usuario p INNER JOIN tipoUsuario c ON p.Id_tipoUsuario = c.id";/*Me trae el id de producto,el nombre de producto, el precio .el id de categoria,el nombre de la categoria*/

    $usuarios = array();

    $result = $mysqli->query($query);

    while($row = $result->fetch_assoc())
    {/*Recorre la matriz resultado de manera asociativa y se guarda en el array alumnos*/
        $usuarios[] = $row;
    }

    $mysqli->close();

    return json_encode($usuarios);
}


function updateUsuario()/*funcion que va a modificar los datos que contiene actualmente la tabla*/
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/
    
    
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';/*recibe una matriz de  tipo POST el cual va a mandar los datos al servidor*/
    var_dump($_POST);
    $contrasenia  =isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '';
    
    $usuario_activo=isset($_POST['usuario_activo']) ? 1 : 0; 

    $dni_usuario= isset($_POST['dni_usuario']) ? $_POST['dni_usuario'] : '';

    $query  = "UPDATE  usuario SET  usuario = '$usuario', contrasenia = '$contrasenia' , usuario_activo = '$usuario_activo',dni_usuario= '$dni_usuario'";
    $query .= " WHERE dni_usuario = '$dni_usuario'";
    

    if(!$mysqli->query($query)){/*condicional que se fija si la sentencia falla o no*/
        return json_encode("No se modificar");/*si falla tira el siguiente msj*/
    }else{ 
        echo "<script>alert('Datos actualizados');</script><br>";
        return json_encode("usuario modificado");/*si la sentencia no falla tira el siguiente msj*/
    }
}

