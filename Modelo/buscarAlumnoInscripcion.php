<?php

include_once('conexion.php');

$dni = isset($_POST['dni']) ? $_POST['dni'] : null;

echo getAlumno($dni);

function getAlumno($dni) {
    $data = array();
    
    if($dni !== null) {
        $mysqli = conexion();

        $query = "SELECT * FROM alumno WHERE dni = ?";
        $stmt = $mysqli->prepare($query); 
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $mysqli->close();
    }

    if (empty($data)) {
        echo json_encode(array("error" => "Alumno no encontrado"));
    } else {
        echo json_encode($data);
    }
}
?>
