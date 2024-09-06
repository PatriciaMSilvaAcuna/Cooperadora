<?php

include_once('conexion.php');//contiene los datos de conexion de la base de datos

$Dni_usuario = isset($_POST['Dni_usuario']) ? $_POST['Dni_usuario'] : null;//informacion que se usa del formulario

echo getUsuario($Dni_usuario);//se llama funcion y se pasa por parametro el dni

function getUsuario($Dni_usuario) {
    if($Dni_usuario !==null){
    $mysqli = conexion();//conecta la base de datos
    $query = "SELECT idusuario, dniusuario,contrasenia, mailusuario, usuarioactivo, idtipousuario FROM usuario WHERE dniusuario = ?";
    $stmt = $mysqli->prepare($query); 

    
    $stmt->bind_param("s", $Dni_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    
    if (count($data) > 0) {
        return json_encode($data);
    } else {
        // Retorna un mensaje de error si no se encuentran resultados
        return json_encode(array('error' => 'No se encontró un usuario con ese DNI.'));
    }
    }
}
