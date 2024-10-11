<?php

include_once('conexion.php');

$mysqli = conexion();
session_start(); // Asegúrate de iniciar la sesión

// Verifica si el idusuario está disponible
if (!isset($_SESSION['idusuario'])) {
    echo json_encode(["error" => "No se ha iniciado sesión correctamente."]);
    exit;
}


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las carreras
$sql = "SELECT idcarrera, carrera FROM carrera";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar las opciones del select
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['idcarrera'] . "'>" . $row['carrera'] . "</option>";
    }
} else {
    echo "<option value=''>No hay carreras disponibles</option>";
}

$conn->close();
?>