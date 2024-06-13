<?php
include_once('conexion.php'); 

$mysqli = conexion();

$dni = $_POST['dni'];

$query = "SELECT id_alumno FROM alumno WHERE dni = ?";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($id_alumno);
    $stmt->fetch();
    echo json_encode($id_alumno);
    $stmt->close();
} else {
    echo json_encode(null);
}

$mysqli->close();
?>