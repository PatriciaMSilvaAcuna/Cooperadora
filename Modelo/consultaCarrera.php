<?php

include_once('conexion.php');// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();

// Inicia la sesión para manejar las variables de sesión del usuario
session_start(); 

// Verifica si el usuario ha iniciado sesión comprobando la existencia de 'idusuario' en la sesión
if (!isset($_SESSION['idusuario'])) {
    // Si no hay sesión iniciada, envía un mensaje de error en formato JSON y termina la ejecución
    echo json_encode(["error" => "No se ha iniciado sesión correctamente."]);
    exit;// Termina el script
}

// Verifica si ocurrió un error en la conexión a la base de datos
if ($conn->connect_error) {
    // Si la conexión falla, muestra un mensaje de error y termina el script
    die("Conexión fallida: " . $conn->connect_error);
}

// Define la consulta SQL para obtener los 'idcarrera' y 'carrera' de la tabla 'carrera'
$sql = "SELECT idcarrera, carrera FROM carrera";
$result = $conn->query($sql);// Ejecuta la consulta y guarda el resultado

// Verifica si la consulta obtuvo algún resultado
if ($result->num_rows > 0) {
    // Genera las opciones para un elemento <select> en HTML
    while ($row = $result->fetch_assoc()) {
        // Crea una opción <option> por cada carrera en la base de datos
        echo "<option value='" . $row['idcarrera'] . "'>" . $row['carrera'] . "</option>";
    }
} else {
     // Si no hay carreras en la base de datos, muestra una opción indicando que no hay datos
    echo "<option value=''>No hay carreras disponibles</option>";
}
// Cierra la concexion con la BBDD.
$conn->close();
?>