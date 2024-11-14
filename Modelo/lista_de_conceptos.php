<?php
include_once('conexion.php');// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$conn = conexion();


// Define la consulta SQL para seleccionar los conceptos.
$sql = "SELECT idconcepto, concepto FROM concepto";

// Ejeuta la consulta y almacena los resultados.
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['idconcepto']}'>{$row['concepto']}</option>";
    }
} else {
    echo '<option value="">No hay conceptos disponibles</option>';
}

// Cierra la conexión a la BBDD.
$conn->close();
?>
