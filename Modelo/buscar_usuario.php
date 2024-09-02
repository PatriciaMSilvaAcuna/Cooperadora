<?php

include_once('conexion.php');//contiene los datos de conexion de la base de datos

$Dni_usuario = isset($_POST['Dni_usuario']) ? $_POST['Dni_usuario'] : null;//informacion que se usa del formulario

echo getUsuario($Dni_usuario);//se llama funcion y se pasa por parametro el dni

function getUsuario($Dni_usuario) {
    if($Dni_usuario !==null){
    $mysqli = conexion();//conecta la base de datos
    $query = "SELECT idusuario, dniusuario,contrasenia, mailusuario, usuarioactivo, idtipousuario FROM usuario WHERE dniusuario = ?";
    $stmt = $mysqli->prepare($query); 
    $response = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        error_log("Datos POST recibidos: " . print_r($_POST, true));
    // Aseguramos que el Dni_usuario está establecido y se escapa para prevenir inyección SQL
        if(isset($_POST['Dni_usuario'])) {
            $Dni_usuario = $mysqli->real_escape_string($_POST['Dni_usuario']);
            error_log("DNI recibido: " . $Dni_usuario);
            
        $query = "SELECT idusuario, mailusuario, contrasenia, dniusuario FROM usuario WHERE dniusuario = ?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) {
            $response = ['estado' => 'ER', 'msg' => 'Error al preparar la consulta: ' . $mysqli->error];
            echo json_encode($response);
            return;
        }
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
>?