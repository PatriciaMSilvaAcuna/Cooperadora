<?php
include_once('conexion.php'); 

$mysqli = conexion();

$valorAbonado = $_POST['valorAbonado'];
$fecha = $_POST['fecha'];
$idUsuario = $_SESSION['idusuario']; 
$id_metodoDePago = $_POST['metodoPago'];
$concepto = $_POST['concepto'];
$id_alumno = $_POST['idalumno'];

$query = "INSERT INTO cargapago (valorabonado, fecha, idusuario, idmetodoDePago, idalumno,idconcepto) VALUES (?, ?, ?, ?, ?,?)";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('ssiiii', $valorAbonado, $fecha, $id_usuario, $id_metodoDePago, $id_alumno, $concepto);
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