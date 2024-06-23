<?php

include_once('conexion.php'); 

//toma los valores del formulario
$fecha = $_POST['año-inscrip'];
$id_alumno = $_POST['id-alumno'];
$id_carrera = $_POST['carreras'];

$query = "INSERT INTO inscripcion (fecha_anual, id_alumno, id_carrera) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('ssiii', $fecha,$id_alumno,$id_carrera);
    if ($stmt->execute()) {
        echo json_encode("Pago registrado con éxito");
    } else {
        echo json_encode("Error al registrar el pago: " . $stmt->error);
    }
    $stmt->close();
} else {
    echo json_encode("Error al preparar la consulta: " . $mysqli->error);
}

$mysqli->close();

?>