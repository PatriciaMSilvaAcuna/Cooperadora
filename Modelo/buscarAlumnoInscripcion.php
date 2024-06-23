<?php

include_once('conexion.php');//contiene los datos de conexion de la base de datos

$dni = isset($_POST['dni']) ? $_POST['dni'] : null;//informacion que se usa del formulario

echo getAlumno($dni);//se llama funcion y se pasa por parametro el dni

function getAlumno($dni) {
   if($dni !==null){

    $mysqli = conexion();//conecta la base de datos

    $query = "SELECT id_alumno, nombre, apellido, dni FROM alumno WHERE dni = ?";
    $stmt = $mysqli->prepare($query); 
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    return json_encode($data);
   }
}
?>