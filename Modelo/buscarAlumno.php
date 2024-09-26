<?php

include_once('conexion.php');//contiene los datos de conexion de la base de datos

$dnialumno = isset($_POST['dnialumno']) ? $_POST['dnialumno'] : null;//informacion que se usa del formulario

echo getAlumno($dnialumno);//se llama funcion y se pasa por parametro el dni

function getAlumno($dnialumno) {
    if($dnialumno !==null){
    $mysqli = conexion();//conecta la base de datos
    $query = "SELECT idalumno, nombre, apellido, dni, deuda, mail, idusuario, fechaalta, alumnoactivo FROM alumno WHERE dni = ?";

    $stmt = $mysqli->prepare($query); 

    
    $stmt->bind_param("s", $dnialumno);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    if ($stmt === false) {
        return json_encode(array('error' => 'Error en la consulta.'));
    }

    if (count($data) > 0) {
        return json_encode($data);
    } else {
        // Retorna un mensaje de error si no se encuentran resultados
        return json_encode(array('error' => 'No se encontró un usuario con ese DNI.'));
    }
    }
}
?>