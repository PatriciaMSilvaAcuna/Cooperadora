
<?php

include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();


// Define la consulta SQL para seleccionar las columnas 'idcarrera' y 'carrera' de la tabla 'carrera'
// Ajusta los nombres de columna y tabla según la estructura de tu base de datos
$query = "SELECT  idcarrera,carrera FROM carrera"; // Ajusta según tu estructura de tabla

// Ejecuta la consulta y almacena el resultado
$result = $mysqli->query($query);

// Inicializa un arreglo vacío para almacenar los datos de las carreras
$carrera = array();

// Recorre cada fila del resultado y la agrega al arreglo $carrera
while($row = $result->fetch_assoc()) {
    $carrera[] = $row;
}

// Cierra la conexión a la base de datos
$mysqli->close();


// Codifica el arreglo $carrera en formato JSON y lo envía como respuesta
// La opción JSON_UNESCAPED_UNICODE asegura que se mantengan los caracteres Unicode sin escape
echo json_encode($carrera, JSON_UNESCAPED_UNICODE);
?>

