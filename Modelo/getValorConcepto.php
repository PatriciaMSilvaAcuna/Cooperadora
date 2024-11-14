<?php
include_once('conexion.php'); //Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso


// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();


// Define la consulta SQL para seleccionar el concepto
$query = "SELECT idconcepto, concepto FROM concepto"; 

// Ejeccuta la consulta y almacena el resultado.
$result = $mysqli->query($query);

//Inicializa un arreglo vacio para almacenar los datos de la consulta.
$metodos = array();
// Recorre cada fila del resultado y la agrega al arreglo.
while($row = $result->fetch_assoc()) {
    $concepto[] = $row;
}

// Cierra la conexioón a la BBDD.

$mysqli->close();


// Codifica el arreglo en formato JSON y lo envia como respuesta.
echo json_encode($concepto);
?>
