<?php
include_once('conexion.php'); 

$mysqli = conexion();

$query = "SELECT idcarrera, carrera FROM carrera"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

$metodos = array();
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

$mysqli->close();

echo json_encode($metodos);
?>
