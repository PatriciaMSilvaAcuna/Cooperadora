<?php
include_once('conexion.php'); // Genero la conexion

$mysqli = conexion();

$query = "SELECT idmetodopago, metodopago FROM metodopago"; 
// Consulta a la BBDD 
$result = $mysqli->query($query);

$metodos = array();
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

$mysqli->close();

echo json_encode($metodos);
?>
