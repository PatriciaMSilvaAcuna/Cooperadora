<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

$function = $_POST['function']; // Recibe el parámetro 'function' enviado por POST para determinar qué función ejecutar.

// Llama a la función correspondiente según el valor de 'function' recibido por POST
if($function == 1) {echo saveNewUser();} // Llama a saveNewUser si la función es 1
else if($function == 2) {echo getUser();}// Llama a getUser si la función es 2
else if($function == 3) {echo updateUsuario();} // Llama a updateUsuario si la función es 3
else if($function == 'checkDNI') { 
    echo checkDNI();// Llama a checkDNI si la función es 'checkDNI'
}



// Función para guardar un nuevo usuario en la base de datos
function saveNewUser()
{
    $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexion en la carpeta modelo.

    // Recibe los datos del formulario enviados por POST
    $dni = $_POST['dni'];
    $contrasenia = $_POST['contrasenia'];
    $mailusuario = $_POST['mailusuario'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $usuarioactivo = 1; // Establece el estado del usuario como activo (1) inicialmente.

     // Prepara la consulta SQL para insertar los datos del usuario en la tabla 'usuario'
    $stmt = $mysqli->prepare("INSERT INTO usuario (dniusuario, contrasenia, mailusuario, idtipousuario, usuarioactivo) VALUES (?, ?, ?, ?, ?)");

    // Enlaza los parámetros para la consulta para evitar inyecciones SQL
    $stmt->bind_param("issii", $dni, $contrasenia, $mailusuario, $tipoUsuario, $usuarioactivo);

    // Ejecuta la consulta y verifica si se realizó correctamente
    if ($stmt->execute()) {
        return json_encode("El usuario fue dado de alta correctamente");
    } else {
        return json_encode("Hubo un fallo al dar de alta el usuario");
    }
}


// Función para obtener usuarios desde la base de datos
function getUser(){

    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/

    // Consulta para verificar si el usuario ya está inactivo.
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


     // Consulta SQL para obtener datos de usuario y su tipo de usuario desde la tabla 'usuario' y 'tipousuario'
    $query = "SELECT p.idusuario as id, p.mailusuario as usuario, p.contrasenia as contrasenia, p.dniusuario as dni, c.id as idcategoria, c.Id_tipoUsuario as tipoUsuario FROM usuario p INNER JOIN tipousuario c ON p.idtipousuario = c.idtipousuario";

    $usuarios = array();// Inicializa el array para almacenar los datos de los usuarios.

    $result = $mysqli->query($query); // Ejecuta la consulta y guarda el resultado.

    while($row = $result->fetch_assoc())
    {/*Recorre la matriz resultado de manera asociativa y se guarda en el array usuarios*/
        $usuarios[] = $row;
    }

    $mysqli->close();// Cierra la conexión con la base de datos.

    return json_encode($usuarios);// Retorna los usuarios en formato JSON.
}

// Función para actualizar datos de un usuario en la base de datos

function updateUsuario()
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/
    
    // Obtiene los datos enviados por POST y los asigna a variables. 
    $mailusuario = isset($_POST['mailusuario']) ? $_POST['mailusuario'] : '';/*recibe una matriz de  tipo POST el cual va a mandar los datos al servidor*/
    var_dump($_POST);
    $contrasenia  =isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '';
    
    $usuario_activo=isset($_POST['usuario_activo']) ? 1 : 0; 

    $dni_usuario= isset($_POST['dni_usuario']) ? $_POST['dni_usuario'] : '';

    // Construye la consulta SQL para actualizar los datos del usuario en la base de datos
    $query  = "UPDATE  usuario SET  mailusuario = '$mailusuario', contrasenia = '$contrasenia' , usuarioactivo = '$usuario_activo',dniusuario= '$dni_usuario'";
    $query .= " WHERE dniusuario = '$dni_usuario'";
    
    // Ejecuta la consulta y verifica si se realizó correctamente
    if(!$mysqli->query($query)){
        return json_encode("No se modificar");/*si falla tira el siguiente msj*/
    }else{ 
        echo "<script>alert('Datos actualizados');</script><br>";
        return json_encode("usuario modificado");/*si la sentencia no falla tira el siguiente msj*/
    }
}

// Función para verificar si un DNI ya existe en la base de datos
function checkDNI() {
    $mysqli = conexion(); // Conexión a la base de datos.

    $dni = $_POST['dni']; // Obtiene el DNI enviado mediante AJAX.

    // Prepara la consulta SQL para contar los registros que coincidan con el DNI dado
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM usuario WHERE dniusuario = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Devuelve en formato JSON si el DNI existe o no
    return json_encode(array('exists' => $count > 0));
}
