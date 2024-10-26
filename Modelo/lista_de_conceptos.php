<?php
include_once('conexion.php');
$conn = conexion();

$sql = "SELECT idconcepto, concepto FROM concepto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['idconcepto']}'>{$row['concepto']}</option>";
    }
} else {
    echo '<option value="">No hay conceptos disponibles</option>';
}
$conn->close();
?>
