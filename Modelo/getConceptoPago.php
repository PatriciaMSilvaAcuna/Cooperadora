<?php
include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();


// Consulta a la BBDD por todos los conceptos exitentes.
$query = "SELECT idconcepto, concepto FROM concepto"; 

// Ejecuta la consulta y almacena el resultado
$result = $mysqli->query($query);


// Inicializa un arreglo vacio para los datos de los conceptos obtenido.
$metodos = array();
// Itera por los resultados obtenidos
while($row = $result->fetch_assoc()) {
    $concepto[] = $row;
}

// Cierra la conexion a la BBDD.
$mysqli->close();

// Codifica el arreglo concepto en formato JSON
echo json_encode($concepto);
?>
