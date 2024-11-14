<?php
include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso


// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();

// Define la consulta SQL para seleccionar las columnas 'idmetodopago' y 'metodopago' de la tabla 'metodopago'

$query = "SELECT idmetodopago, metodopago FROM metodopago"; 

// Ejecuta la consulta y almacena el resultado
$result = $mysqli->query($query);

// Inicializa un arreglo vacío para almacenar los datos de los metodos de pagos.
$metodos = array();
// Recorre cada fila del resultado y la agrega al arreglo metodos.
while($row = $result->fetch_assoc()) {
    $metodos[] = $row;
}

// Cierra la conexion a la BBDD.
$mysqli->close();

// Codifica el arreglo en formaro JSON

echo json_encode($metodos);
?>
