
<?php

include_once('conexion.php'); // Asegúrate de que la ruta sea correcta

$mysqli = conexion();

$query = "SELECT  idcarrera,carrera FROM carrera"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

$carrera = array();
while($row = $result->fetch_assoc()) {
    $carrera[] = $row;
}

$mysqli->close();

echo json_encode($carrera, JSON_UNESCAPED_UNICODE);
?>

