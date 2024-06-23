<?php
include_once('conexion.php'); // Asegúrate de que la ruta sea correcta

$mysqli = conexion();

$query = "SELECT id_carrera, carrera FROM carrera"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

$metodos = array();
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

$mysqli->close();

echo json_encode($metodos);
?>
