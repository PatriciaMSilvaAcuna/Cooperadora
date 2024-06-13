<?php

include_once('conexion.php');

$dni = isset($_POST['dni']) ? $_POST['dni'] : '';

echo getAlumno($dni);

function getAlumno($dni) {
    $mysqli = conexion();

    $query = "SELECT id_alumno, nombre, apellido, dni, deuda FROM alumno WHERE dni = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    $alumno = array();

    while ($row = $result->fetch_assoc()) {
        $alumno[] = $row;
    }

    $stmt->close();
    $mysqli->close();

    return json_encode($alumno);
}
?>
