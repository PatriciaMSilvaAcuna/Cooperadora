<?php
// /Modelo/listar_carreras.php

header('Content-Type: text/html; charset=utf-8'); // Asegura que el contenido se muestre correctamente

include_once('conexion.php');

session_start(); // Iniciar sesión

$conn = conexion(); // Obtener conexión

// Verifica si el idusuario está disponible
if (!isset($_SESSION['idusuario'])) {
    // En lugar de JSON, devolvemos una opción indicando el error
    echo "<option value=''>Error: No se ha iniciado sesión correctamente.</option>";
    exit;
}

// Consulta para obtener las carreras
$sql = "SELECT idcarrera, carrera FROM carrera";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar las opciones del select
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($row['idcarrera']) . "'>" . htmlspecialchars($row['carrera']) . "</option>";
    }
} else {
    echo "<option value=''>No hay carreras disponibles</option>";
}

$conn->close();
?>
