<?php
include_once('conexion.php'); 

$mysqli = conexion();

$valorAbonado = $_POST['valorAbonado'];
$fecha = $_POST['fecha'];
$id_usuario = 2; // Puedes ajustar este valor según sea necesario
$id_metodoDePago = $_POST['metodoPago'];
$id_alumno = $_POST['id_alumno'];

$query = "INSERT INTO carga_pago (valorAbonado, fecha, id_usuario, id_metodoDePago, id_alumno) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('ssiii', $valorAbonado, $fecha, $id_usuario, $id_metodoDePago, $id_alumno);
    if ($stmt->execute()) {
        echo json_encode("Pago registrado con éxito");
    } else {
        echo json_encode("Error al registrar el pago: " . $stmt->error);
    }
    $stmt->close();
} else {
    echo json_encode("Error al preparar la consulta: " . $mysqli->error);
}

$mysqli->close();


?>