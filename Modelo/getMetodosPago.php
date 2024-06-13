<?php
include_once('conexion.php'); // Asegúrate de que la ruta sea correcta

$mysqli = conexion();

$query = "SELECT id_metodoDePago, tipo_de_Pago FROM metodo_de_pago"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

$metodos = array();
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

$mysqli->close();

echo json_encode($metodos);
?>
