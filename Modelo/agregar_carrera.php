<?php
// Conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    
    if (!empty($nombre)) {
        // Inserción de la nueva carrera
        $sql = "INSERT INTO carrera (carrera) VALUES ('$nombre')";
        if (mysqli_query($conn, $sql)) {
            echo "Carrera agregada exitosamente.";
        } else {
            echo "Error al agregar la carrera: " . mysqli_error($conn);
        }
    } else {
        echo "El nombre de la carrera no puede estar vacío.";
    }
    
    mysqli_close($conn);
}
?>
