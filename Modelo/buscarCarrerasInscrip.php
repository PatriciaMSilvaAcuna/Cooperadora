<?php
include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso


// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();


// Define la consulta SQL para seleccionar las columnas 'idcarrera' y 'carrera' de la tabla 'carrera'
$query = "SELECT idcarrera, carrera FROM carrera"; // Ajusta según tu estructura de tabla
$result = $mysqli->query($query);

// Inicializa un arreglo vacío para almacenar los datos de las carreras
$metodos = array();

// Recorre cada fila del resultado y la agrega al arreglo $metodos.
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

// Cierra la conexión a la base de datos
$mysqli->close();

// Codifica el arreglo $metodos en formato JSON y lo envía como respuesta
echo json_encode($metodos);
?>
