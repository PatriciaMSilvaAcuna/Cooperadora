<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

$function = $_POST['function'];

if($function == 1) {echo saveNewUser();}
else if($function == 2) {echo getUser();}
else if($function == 3) {echo updateUsuario();}
else if($function == 'checkDNI') { 
    echo checkDNI();
}


function saveNewUser()
{
    $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexion en la carpeta modelo.

    $dni = $_POST['dni'];
    $contrasenia = $_POST['contrasenia'];
    $mailusuario = $_POST['mailusuario'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $usuarioactivo = 1; // El usuario siempre estará activo inicialmente.

    // Preparar la consulta SQL para insertar directamente en la tabla 'usuario'
    $stmt = $mysqli->prepare("INSERT INTO usuario (dniusuario, contrasenia, mailusuario, idtipousuario, usuarioactivo) VALUES (?, ?, ?, ?, ?)");

    // Enlazar parámetros
    $stmt->bind_param("issii", $dni, $contrasenia, $mailusuario, $tipoUsuario, $usuarioactivo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        return json_encode("El usuario fue dado de alta correctamente");
    } else {
        return json_encode("Hubo un fallo al dar de alta el usuario");
    }
}



function getUser(){/*funcion que va a solicitar al servidor una informacion*/
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/
    // Consulta para verificar si el usuario ya está inactivo
    $consultaUsuario = "SELECT usuarioactivo FROM usuario WHERE dniusuario = $dni";
    $stmtConsulta = $mysqli->prepare($consultaUsuario);
    $stmtConsulta->bind_param("s", $usuario);
    $stmtConsulta->execute();
    $stmtConsulta->bind_result($usuarioActivo);
    $stmtConsulta->fetch();
    $stmtConsulta->close();
    if ($usuarioActivo === "0") {
        return json_encode("El usuario ya está dado de baja.");
    }



    $query = "SELECT p.idusuario as id, p.mailusuario as usuario, p.contrasenia as contrasenia, p.dniusuario as dni, c.id as idcategoria, c.Id_tipoUsuario as tipoUsuario FROM usuario p INNER JOIN tipousuario c ON p.idtipousuario = c.idtipousuario";

    $usuarios = array();

    $result = $mysqli->query($query);

    while($row = $result->fetch_assoc())
    {/*Recorre la matriz resultado de manera asociativa y se guarda en el array usuarios*/
        $usuarios[] = $row;
    }

    $mysqli->close();

    return json_encode($usuarios);
}


function updateUsuario()/*funcion que va a modificar los datos que contiene actualmente la tabla*/
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/
    
    
    $mailusuario = isset($_POST['mailusuario']) ? $_POST['mailusuario'] : '';/*recibe una matriz de  tipo POST el cual va a mandar los datos al servidor*/
    var_dump($_POST);
    $contrasenia  =isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '';
    
    $usuario_activo=isset($_POST['usuario_activo']) ? 1 : 0; 

    $dni_usuario= isset($_POST['dni_usuario']) ? $_POST['dni_usuario'] : '';

    $query  = "UPDATE  usuario SET  mailusuario = '$mailusuario', contrasenia = '$contrasenia' , usuarioactivo = '$usuario_activo',dniusuario= '$dni_usuario'";
    $query .= " WHERE dniusuario = '$dni_usuario'";
    

    if(!$mysqli->query($query)){/*condicional que se fija si la sentencia falla o no*/
        return json_encode("No se modificar");/*si falla tira el siguiente msj*/
    }else{ 
        echo "<script>alert('Datos actualizados');</script><br>";
        return json_encode("usuario modificado");/*si la sentencia no falla tira el siguiente msj*/
    }
}

function checkDNI() {
    $mysqli = conexion(); // Conexión a la base de datos.

    $dni = $_POST['dni']; // Obtén el DNI enviado desde el AJAX.

    // Consulta para verificar si el DNI ya está registrado.
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM usuario WHERE dniusuario = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Devolvemos un JSON con el resultado.
    return json_encode(array('exists' => $count > 0));
}
