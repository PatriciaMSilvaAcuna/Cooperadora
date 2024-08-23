<?php
include_once('conexion.php'); // Asegúrate de que la ruta sea correcta

$mysqli = conexion();

$query = "SELECT idconcepto, concepto FROM concepto"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

$metodos = array();
while($row = $result->fetch_assoc()) {
    $concepto[] = $row;
}

$mysqli->close();

echo json_encode($concepto);
?>
